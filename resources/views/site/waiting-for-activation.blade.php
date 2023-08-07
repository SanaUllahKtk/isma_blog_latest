<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISMA</title>
    <style>
        body {
            background: #00091B;
            color: #fff;
        }


        @keyframes fadeIn {
            from {
                top: 20%;
                opacity: 0;
            }

            to {
                top: 100;
                opacity: 1;
            }

        }

        @-webkit-keyframes fadeIn {
            from {
                top: 20%;
                opacity: 0;
            }

            to {
                top: 100;
                opacity: 1;
            }

        }

        .wrapper {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            animation: fadeIn 1000ms ease;
            -webkit-animation: fadeIn 1000ms ease;

        }

        h1 {
            font-size: 50px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 0;
            line-height: 1;
            font-weight: 700;
            text-align: center
        }

        .dot {
            color: #4FEBFE;
        }

        p {
            text-align: center;
            margin: 18px;
            font-family: 'Muli', sans-serif;
            font-weight: normal;

        }

        .icons {
            text-align: center;

        }

        .icons i {
            color: #00091B;
            background: #fff;
            height: 15px;
            width: 15px;
            padding: 13px;
            margin: 0 10px;
            border-radius: 50px;
            border: 2px solid #fff;
            transition: all 200ms ease;
            text-decoration: none;
            position: relative;
        }

        .icons i:hover,
        .icons i:active {
            color: #fff;
            background: none;
            cursor: pointer !important;
            transform: scale(1.2);
            -webkit-transform: scale(1.2);
            text-decoration: none;

        }
    </style>
</head>

<body>
    <div class="wrapper">

        <h1> Hiii {{ $user->name }}<span class="dot">.</span></h1>
        <p>
            Your account is not activated yet. Please wait for the admin to activate your account.
        </p>
    </div>
</body>

</html>
