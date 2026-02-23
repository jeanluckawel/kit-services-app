<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de Paie - {{ $employee->employee_id ?? '' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f4f7; padding:20px;">

<div style="max-width:700px; margin:auto; background-color:#ffffff; border:1px solid #e0e0e0; border-radius:0;">

    <!-- Header -->
    <div style="background-color:#ff6600; color:#ffffff; text-align:center; padding:15px; border-radius:0;">
        <h2 style="margin:0; font-size:18px;">Bulletin de Paie</h2>
    </div>

    <!-- Informations Employé -->
    <div style="padding:15px;">
        <h3 style="margin:0 0 10px 0; font-size:16px; color:#FF6600;">Informations Employé</h3>
        <table style="width:100%; border-collapse: collapse; font-size:14px;">
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Nom</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $employee->first_name ?? '' }} {{ $employee->middle_name ?? '' }} {{ $employee->last_name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Matricule</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $employee->employee_id ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Période</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">
{{--                    {{ \Carbon\Carbon::create()->month($quickPay->period)->format('F') }} {{ $quickPay->year }}--}}
                    {{ $quickPay->period }} -  {{ $quickPay->year }}
                </td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Département</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{  $employee->company?->DepartmentRelation?->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Fonction</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $employee->company->jobTitleRelation->name ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>


    <div style="padding:15px; border-top:1px solid #eee;">
        <h3 style="margin:0 0 10px 0; font-size:16px; color:#FF6600;">Détails Salaire</h3>
        <table style="width:100%; border-collapse: collapse; font-size:14px;">
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Jours prestés</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $quickPay->day_work }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Salaire travail</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ number_format($quickPay->work, 2) }} $</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Jours maladie</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $quickPay->day_sick }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Salaire maladie</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ number_format($quickPay->sick, 2) }} $</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Heures supplémentaires</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $quickPay->day_overtime }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Salaire overtime</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ number_format($quickPay->overtime, 2) }} $</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd;"><strong>Taux de change</strong></td>
                <td style="padding:6px; border:1px solid #ddd;">{{ $quickPay->exchange_rate }}</td>
            </tr>
            <tr>
                <td style="padding:6px; border:1px solid #ddd; font-weight:bold; background:#fff3cd;" colspan="2">
                    Total Salaire (USD) : {{ number_format($quickPay->work + $quickPay->sick + $quickPay->overtime, 2) }}
                </td>
            </tr>
        </table>
    </div>


    <div style="margin-top:20px; padding:10px; font-size:12px; color:#888888; text-align:center; line-height:1.4; border-top:1px solid #eeeeee;">
        Cordialement, Payroll<br>
        <strong>Kit Services</strong>
    </div>

</div>

</body>
</html>
