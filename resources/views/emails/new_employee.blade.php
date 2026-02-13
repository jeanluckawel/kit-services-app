<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvel Employé</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f4f7; padding:20px;">

<div style="
    max-width:600px;
    margin:auto;
    background-color:#ffffff;
    border:1px solid #e0e0e0;
    border-radius:0;
">

    <!-- Header -->
    <div style="
        background-color:#ff6600;
        color:#ffffff;
        text-align:center;
        padding:15px;
        border-radius:0;
    ">
        <h2 style="margin:0; font-size:18px;">Nouvel Employé</h2>
    </div>

    <!-- Content -->
    <div style="
        padding:15px;
        color:#333333;
        font-size:14px;
        line-height:1.6;
        border-radius:0;
    ">
        <p>Un Nouvel employé créé avec succès.</p>

        <p>
            <strong>Nom :</strong> {{ $employee->first_name ?? '' }} {{ $employee->last_name ?? '' }}<br>
            <strong>Matricule :</strong> {{ $employee->employee_id ?? '' }}<br>
            <strong>Département :</strong> {{ $employee->department ?? 'N/A' }}
        </p>
    </div>

    <!-- Footer -->
    <div style="
        margin-top:20px;
        padding:10px;
        font-size:12px;
        color:#888888;
        text-align:center;
        line-height:1.4;
        border-radius:0;
        border-top:1px solid #eeeeee;
    ">
        Cordialement,<br>
        <strong>Kit Services</strong> – Équipe Support
    </div>

</div>

</body>
</html>
