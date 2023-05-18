<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400');

        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400');

        body {
            font-family: "Roboto", Arial, Sans;
            padding: 1.6rem;
            color: #555;
        }

        h1 {
            font-size: 1.8rem;
            margin-top: 0.3rem;
            margin-bottom: 3.5rem;
            padding-bottom: 1.5rem;
            font-weight: normal;
            border-bottom: 1px solid #c5c5c5;
            font-weight: 300;
        }

        input {
            font-size: 1rem;
            padding: 0.5rem;
            border: 1px solid #c5c5c5;
            color: #555;
        }

        span {
            display: inline-block;
            vertical-align: middle;
            margin-right: 0.3rem;
        }

        .results {
            position: relative;
            margin-bottom: 3.5rem;
        }

        .results .box {
            display: inline-block;
            position: relative;
            vertical-align: middle;
            min-width: 10rem;
            box-shadow: 0 0.3rem 0.8rem 0 rgba(0, 0, 0, 0.2);
            background: #fff;
            padding: 2rem;
        }

        .color-circle {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
        }

        .hexcode {
            display: block;
            font-size: 0.8rem;
            position: absolute;
            top: -1.6rem;
            left: -0.6rem;
            height: 4rem;
            min-width: 10rem;
            padding: 0.4rem 0.4rem 0.4rem 0.6rem;
            color: #fff;
            margin-right: 0;
        }

        .sliders {
            margin-top: 1rem;
        }

        .sliders label {
            display: block;
            margin-top: 1.5rem;
        }

        .slider {
            margin-top: 1rem;
            width: 100%;
            display: inline-block;
        }

        .ui-slider .custom-handle {
            width: 2.5em;
            height: 1.6em;
            top: 50%;
            margin-top: -.8em;
            text-align: center;
            line-height: 1.6em;
        }
    </style>
</head>




<body>

    <h1>Compute HSL color code for an arbitrary string.</h1>

    <div class="results">
        <span class="hexcode"></span>
        <div class="box">
            <span class="color-circle"></span>
            <span class="string">Sergio Pedercini</span>
        </div>
    </div>

    <div>
        <label for="string">String</label>
        <input type="text" id="string">
    </div>

    <div class="sliders">
        <div>
            <label>Saturation</label>
            <div id="saturation" class="slider">
                <div class="ui-slider-handle custom-handle"></div>
            </div>
        </div>

        <div>
            <label>Lightness</label>
            <div id="lightness" class="slider">
                <div class="ui-slider-handle custom-handle"></div>
            </div>
        </div>
    </div>

    <!----------------------------------------------------------------------------  -->


    <script>
        $(document).ready(function() {

            function stringToHslColor(str, s, l) {
                var hash = 0;
                for (var i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                var h = hash % 360;
                return 'hsl(' + h + ', ' + s + '%, ' + l + '%)';
            }

            function updateColor() {
                var inputField = $('input');
                var s = $('#saturation').slider("value");
                var l = $('#lightness').slider("value");
                var textColor = l > 70 ? '#555' : '#fff';

                var hexColor = stringToHslColor(inputField.val(), s, l);
                $('.hexcode').html(hexColor).css({
                    'background-color': hexColor,
                    'color': textColor
                });
                $('.results .string').html(inputField.val());
                $('.color-circle').css('background-color', hexColor);
            }

            $('.slider').each(function() {
                var handle = $(this).find('.custom-handle');

                $(this).slider({
                    create: function() {
                        handle.text($(this).slider("value"));
                    },
                    slide: function(event, ui) {
                        updateColor();
                        handle.text($(this).slider("value"));
                    }
                });
            });

            $('input').keyup(function() {
                updateColor()
            });

            // Init values
            $('#string').val('Sergio Pedercini');
            $('#saturation').slider('value', 30);
            $('#lightness').slider('value', 80);
            $('#saturation .custom-handle').text('30');
            $('#lightness .custom-handle').text('80');
            updateColor();

        });
    </script>

</body>

</html>