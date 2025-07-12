<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo messaggio dal sito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #01b3a7;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 3px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nuovo messaggio dal sito</h1>
    </div>
    
    <div class="content">
        <p>È stato ricevuto un nuovo messaggio dal modulo di contatto del sito web della Banda Folk di Castello Tesino.</p>
        
        <div class="field">
            <div class="label">Nome:</div>
            <div class="value">{{ $contact->name }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email:</div>
            <div class="value">{{ $contact->email }}</div>
        </div>
        
        <div class="field">
            <div class="label">Oggetto:</div>
            <div class="value">{{ $contact->subject }}</div>
        </div>
        
        <div class="field">
            <div class="label">Messaggio:</div>
            <div class="value">{{ $contact->message }}</div>
        </div>
        
        <div class="field">
            <div class="label">Data e ora:</div>
            <div class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
        </div>
        
        <div class="field">
            <div class="label">Indirizzo IP:</div>
            <div class="value">{{ $contact->ip_address }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Questo è un messaggio automatico. Si prega di non rispondere a questa email.</p>
        <p>© {{ date('Y') }} Banda Folk di Castello Tesino - Tutti i diritti riservati</p>
    </div>
</body>
</html>
