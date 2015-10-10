<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <title>VOIDTE.AM</title>
        <meta name="description" content="VoidTeam branded URL shortener.">
        <meta name="keywords" content="VoidTeam, Network, Studios, URL, Shortener, Link, Shorten">
        <meta name="author" content="VoidTeam Studios">
        <link href="http://voidte.am" rel="canonical">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-k2/8zcNbxVIh5mnQ52A0r3a6jAgMGxFJFE2707UxGCk= sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet" type="text/css">

        <style>
            html, body, .offset {
                height: 100%;
            }
            body {
                background: url('http://voidteam.net/img/pattern-bg.png') #1a4674 repeat;
                color: white;
                display: table;
                font-family: 'Lato';
                margin: 0;
                padding: 0;
                text-align: center;
                width: 100%;
            }
            .alert {
                border-radius: 0;
                text-align: left;
            }
            .btn {
                border-radius: 0;
                text-transform: uppercase;
            }
            .container {
                display: inline-block;
                vertical-align: middle;
            }
            .form-control {
                border-radius: 0;
            }
            .offset {
                display: inline-block;
                vertical-align: middle;
            }
            .preloader {
                font-size: 72px;
            }
            .title {
                font-size: 96px;
                font-weight: normal;
                margin: 0 0 1em 0;
            }
            @media screen and (max-width: 767px) {
                .btn-lg {
                    font-size: 14px;
                    line-height: 1.42857143;
                    padding: 6px 12px;
                }

                .input-lg {
                    height: 34px;
                    font-size: 14px;
                    line-height: 1.42857143;
                    padding: 6px 12px;
                }

                .title {
                    font-size: 38px;
                }
            }
        </style>
    </head>
    <body>
        <div class="offset"></div>
        <div class="container">
            <div class="alert-container">
            </div>
            <h1 class="title">VOIDTE.AM</h1>
            <div class="form">
                <form action="/shorten" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control input-lg" name="shorten" id="shorten" required="required" placeholder="http://voidteam.net">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-lg btn-submit" type="submit">Shorten</button>
                                <button class="btn btn-primary btn-lg btn-copy" type="button" style="display: none;">Copy</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="preloader" style="display: none;">
                <span class="fa fa-circle-o-notch fa-spin"></span>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
        <script>
            $('.btn-copy').on('click', function(e) {
                e.preventDefault();

                copyToClipboard();
            });

            $('form').on('submit', function(e) {
                e.preventDefault();

                if ($('input').val().trim() != '' && validUrl($('input').val().trim()))
                {
                    getShortenedUrl($('input').val().trim());
                }
            });

            $('input').on('input', function(e) {
                $('.btn-copy').hide();
                $('.btn-submit').show();
            });

            function copyToClipboard()
            {
                $('input').select();

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    $('input').select();
                }
                catch (err) {
                    showAlert('Oops, unable to copy', 'danger');
                }

                showAlert('Successfully copied.', 'success');
            }

            function getShortenedUrl(url)
            {
                $('.form').hide();
                $('.alert-container').html('');
                $('.preloader').show();

                $.ajax({
                    type: 'POST',
                    url: '/shorten',
                    dataType: 'json',
                    data: {
                        shorten: url,
                        user: '',
                        via: 'Shortener Page'
                    },
                    success: function(data) {
                        $('input').val(data.link);
                        $('.btn-copy').show();
                        $('.btn-submit').hide();

                        $('.preloader').hide();
                        $('.form').show();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        showAlert(errorThrown, 'danger');
                        $('.preloader').hide();
                        $('.form').show();
                    }
                });
            }

            function showAlert(text, type)
            {
                $('.alert-container').html(
                    '<div class="alert alert-' + type + '">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        text +
                    '</div>'
                );
            }

            function validUrl(str)
            {
                var pattern = new RegExp(
                    '^(https?:\\/\\/)?' + // protocol
                    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                    '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                    '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                    '(\\#[-a-z\\d_]*)?$','i'
                ); // fragment locator

                if (!pattern.test(str))
                {
                    showAlert('Please enter a valid URL.', 'danger');
                    return false;
                }
                else
                {
                    return true;
                }
            }
        </script>
    </body>
</html>
