$(document).ready( function()
{

    var freq_5 = 500;
    var freq1 = 1000;
    var freqUpdatePage = 7000;

    var updated = (new Date()).getTime();
    var updateFrom = $('#updated-from');
    var updateNowLink = $('#updated-from-link');

    var pageUrl = window.location.href;

    var fromTicker = (pageUrl.substr(pageUrl.lastIndexOf('/') + 1)).toUpperCase();
    var toTicker   = 'BTC';

    var fromPriceUSD = $('#from-price-usd');
    var fromPriceBTC = $('#from-price-btc');
    var toPriceUSD =   $('#to-price-usd');
    var coinToBTC = parseFloat(fromPriceBTC.text().replace(/,/g, '')).toPrecision(6);

    var fromAmount =   parseFloat($('input[name="from-amount"]').val());
    var toAmount =     parseFloat($('input[name="to-amount"]').val());
    var fromPricePer = parseFloat($('input[name="from-price-per"]').val());
    var toPricePer =   parseFloat($('input[name="to-price-per"]').val());
    var fromFees =     parseFloat($('input[name="from-fees"]').val());
    var toFees =       parseFloat($('input[name="to-fees"]').val());


    var resultSection = $('#result-section');
    var resultBenefitValue = $('#USD-result');


    var convertCoin = $('input[name="converter-coin-value"]');
    var convertUSD =  $('input[name="converter-usd-value"]');
    var convertBTC =  $('input[name="converter-btc-value"]');


    // var internalApiUrl = 'http://localhost:8000/api/coin/';
    var internalApiUrl = 'http://coin.aba.ae/api/coin/';


    function isNumeric(n) {
        return /\d/.test(n);
    }
    

    function updateLastUpdated(updateLast) {
        //Updated From
        var timestamp = (new Date()).getTime();
        var diffSec = Math.floor((timestamp - updated) / 1000);
        updateFrom.text('updated: ' + diffSec + ' second' + (diffSec > 1 ? 's' : '') + ' ago');
        if (updateLast) updated = timestamp;
    }

    function formFilled() {

        return isNumeric(fromAmount) && isNumeric(toAmount)
        && isNumeric(fromPricePer) && isNumeric(toPricePer);
    }


    function toFixed(x) {
        if (Math.abs(x) < 1.0) {
            var e = parseInt(x.toString().split('e-')[1]);
            if (e) {
                x *= Math.pow(10,e-1);
                x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
            }
        } else {
            var e = parseInt(x.toString().split('+')[1]);
            if (e > 20) {
                e -= 20;
                x /= Math.pow(10,e);
                x += (new Array(e+1)).join('0');
            }
        }
        return x;
    }

    function calculate() {

        if (!formFilled()) return;


        // in BTC
        var buyAmountInBTC = (fromAmount * fromPricePer);

        var sellAmountInBTC = (toAmount * toPricePer);

        var totalAmountWithoutFees = (buyAmountInBTC + sellAmountInBTC);

        if (isNaN(fromFees)) fromFees = 0.0;
        if (isNaN(toFees)) toFees = 0.0;

        var fromFeesInBTC = ( (fromFees/100) * buyAmountInBTC);
        var toFeesInBTC = ( (toFees/100) * sellAmountInBTC);

        var finalTotalReturnInBTC = ((sellAmountInBTC - fromFeesInBTC) - (buyAmountInBTC + toFeesInBTC));

        finalTotalReturnInBTC = (finalTotalReturnInBTC * parseFloat(toPriceUSD.text().replace(/,/g, ''))).toPrecision(6);

        if (finalTotalReturnInBTC > 0.0)
        {
            resultBenefitValue.html('<span class="alert-success d-inline p-2"> ' + toFixed(finalTotalReturnInBTC) + ' USD</span>');
        }else
        {
            resultBenefitValue.html('<span class="alert-danger d-inline p-2"> ' + toFixed(finalTotalReturnInBTC) + ' USD</span>');
        }
    }




    // Convert coin ==========================
    function convertFromCoin()
    {
        convertCoin = parseFloat($('input[name="converter-coin-value"]').val());
        $('input[name="converter-usd-value"]').val(toFixed(convertCoin * parseFloat(fromPriceUSD.text())));
        convertUSD = parseFloat($('input[name="converter-usd-value"]').val());
        coinToBTC = parseFloat(fromPriceBTC.text().replace(/,/g, '')).toPrecision(6);
        var convertInBTC = (coinToBTC * convertCoin);
        $('input[name="converter-btc-value"]').val(toFixed(convertInBTC));
    }

    $('input[name="converter-coin-value"]').on('keyup', function ()
    {
        convertFromCoin();
    });

    $('input[name="converter-usd-value"]').on('keyup', function ()
    {
        convertUSD = this.value;
        $('input[name="converter-coin-value"]').val(toFixed(convertUSD / parseFloat(fromPriceUSD.text())));
        $('input[name="converter-btc-value"]').val(toFixed(convertUSD / parseFloat(toPriceUSD.text().replace(/,/g, ''))));
    });

    $('input[name="converter-btc-value"]').on('keyup', function ()
    {
        convertBTC = this.value;
        $('input[name="converter-usd-value"]').val(convertBTC * parseFloat(toPriceUSD.text().replace(/,/g, '')));
        convertUSD = parseFloat($('input[name="converter-usd-value"]').val());
        $('input[name="converter-coin-value"]').val(toFixed(convertUSD / parseFloat(fromPriceUSD.text())));
    });
    // ====================================






    function updatePage() {

        //Prices in USD
        var fromResult;
        var toResult;


        $.when(
            $.ajax({ // First Request
                url: (internalApiUrl + fromTicker),
                type: 'GET',
                data: null,
                cache: false,
                success: function(data){
                    data = JSON.parse(data);
                    fromResult = data;
                }
            }),

            $.ajax({ //Seconds Request
                url: internalApiUrl + toTicker,
                type: 'GET',
                data: null,
                cache: false,
                success: function(data){
                    data = JSON.parse(data);
                    toResult = data;
                }
            })

        ).then(function() {

            fromPriceUSD.text(toFixed(fromResult.USD));
            fromPriceBTC.text(toFixed(fromResult.BTC));
            toPriceUSD.text(toResult.USD);

        });

        updateLastUpdated(true);
        coinToBTC = parseFloat(fromPriceBTC.text().replace(/,/g, ''));

    }



    updateNowLink.on('click', function ()
    {
        updatePage();
    });



    // benefit form ==============================================
    function setBenefitPerPrices()
    {
        $('input[name="from-price-per"]').val(toFixed(coinToBTC));
        $('input[name="to-price-per"]').val(toFixed(coinToBTC));
    }

    function updateBenefitForm()
    {
        fromAmount   = parseFloat($('input[name="from-amount"]').val());
        toAmount     = parseFloat($('input[name="to-amount"]').val());
        fromPricePer = parseFloat($('input[name="from-price-per"]').val());
        toPricePer   = parseFloat($('input[name="to-price-per"]').val());
        fromFees     = parseFloat($('input[name="from-fees"]').val());
        toFees       = parseFloat($('input[name="to-fees"]').val());

        if (!formFilled())
        {
            resultSection.addClass('d-none');
            document.body.style.cursor = 'default';
            return;
        }

        document.body.style.cursor = 'wait';

        updatePage();

        setTimeout(function ()
        {
            resultSection.removeClass('d-none');
            calculate();
            document.body.style.cursor = 'default';
        }, freq_5);
    }

    $('input[name="from-price-per"], ' +
        'input[name="to-price-per"], ' +
        'input[name="from-amount"], ' +
        'input[name="to-amount"], ' +
        'input[name="from-fees"], ' +
        'input[name="to-fees"]').on('keyup', function ()
    {
        updateBenefitForm();
    });

    $('#from-current-per-btc').on('click', function ()
    {
        $('input[name="from-price-per"]').val(toFixed(coinToBTC));
        updateBenefitForm();
    });
    $('#to-current-per-btc').on('click', function ()
    {
        $('input[name="to-price-per"]').val(toFixed(coinToBTC));
        updateBenefitForm();
    });

    // ==========================================



    //REAL-TIME
    setInterval(function ()
    {
        updatePage();
    }, freqUpdatePage);


    setInterval(function ()
    {
        updateLastUpdated(false);
    }, freq1);

    updatePage();
    convertFromCoin();
    setBenefitPerPrices();



});

