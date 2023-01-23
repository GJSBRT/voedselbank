<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @font-face {
            font-family: 'Elegance';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("http://eclecticgeek.com/dompdf/fonts/Elegance.ttf") format("truetype");
        }
        body {
            font-family: Elegance, sans-serif;
            font-size: 14px;
            width: 725px;
            height: 1122px;
        }
        table {
            width: 98%;
        }
        header td {
            text-align: left;
            width: 50%;
        }
        header td:nth-child(2) {
            float: right;
            text-align: right;
        }
        .data {
            padding: 25px 0 0 0;
        }
        .data td {
            vertical-align: top;
            text-align: left;
        }
        .data td:nth-child(1) {
            width: 45%;
        }
    </style>
</head>
<body>
<div id="body">
    <header>
        <table>
            <tr>
                <td>
                    <img width="300px" src="@include('pdf.image')"> <br>
                </td>
                <td style="margin-right: 25px">
                    <h1>Gegevens van {{$customer['first_name']}}</h1>
                    {{\Carbon\Carbon::now()}}
                </td>
            </tr>
        </table>
    </header>

    <div class="data">
        <table>
            <tr>
                <td>Voornaam: {{$customer['first_name']}} </td>
                <td>Telefoon: {{$customer['phone_number']}}</td>
            </tr>
            <tr>
                <td>E-mailadres: {{$customer['email']}}</td>
                <td>Adres: {{$customer['address']}}</td>
            </tr>
            <tr>
                <td>Achternaam: {{$customer['last_name']}}</td>
                <td>Aantal Volwassen: {{$customer['adult_amount']}}</td>
            </tr>
            <tr>
                <td>Aantal kinderen: {{$customer['child_amount']}}</td>
                <td>Aantal babies: {{$customer['baby_amount']}}</td>
            </tr>
        </table>
    </div>

    <div class="data">
        <table>
            <tr>
                <td>Notities:</td>
                <td>{{$customer['notes']}}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
