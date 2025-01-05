<?php

$csvFile = file('bitvavo.csv');
$fileData = [];
$finalData = [
    [
        "Date (UTC)",
        "Integration Name",
        "Label",
        "Outgoing Asset",
        "Outgoing Amount",
        "Incoming Asset",
        "Incoming Amount",
        "Fee Asset (optional)",
        "Fee Amount (optional)",
        "Comment (optional)",
        "Trx. ID (optional)",
    ]
];
foreach ($csvFile as $key => $line) {
    if ($key == 0) continue;
    $fileData[] = str_getcsv($line);
}
// Bitvavo file
//Timezone
//Date
//Time
//Type
//Currency
//Amount
//Quote Currency
//Quote Price
//Received / Paid
//Currency
//Received / Paid Amount
//Fee currency
//Fee amount
//Status
//Transaction ID
//Address

foreach ($fileData as $line) {
    $record = [];

    $date = new DateTime("$line[1] $line[2]", new DateTimeZone($line[0]));
    $date->setTimezone(new DateTimeZone('UTC'));
    $utcDateTime = $date->format('d.m.Y H:i:s');
    $record[] = $utcDateTime;
    $record[] = "Bitvavo Manual Import";

    switch ($line[3]) { //type
        case "withdrawal":
            $record[] = "Withdrawal";
            $record[] = $line[4]; //currency
            $record[] = abs($line[5]); //amount
            $record[] = ""; //incoming asset
            $record[] = ""; //incoming amount
            $record[] = $line[10]; //fee asset
            $record[] = $line[11]; //fee amount
            $record[] = $line[14]; //comment (bitvavo address)
            break;
        case "deposit":
            $record[] = "Deposit";
            $record[] = ""; //outgoing currency
            $record[] = ""; //outgoing amount
            $record[] = $line[4]; //incoming asset
            $record[] = $line[5]; //incoming amount
            $record[] = ""; //fee asset
            $record[] = ""; //fee amount
            $record[] = $line[14]; //comment (bitvavo address)
            break;
        case "sell":
            $record[] = "Trade";
            $record[] = $line[4]; //outgoing currency
            $record[] = abs($line[5]); //outgoing amount
            $record[] = $line[8]; //incoming asset
            $record[] = $line[9]; //incoming amount
            $record[] = $line[10]; //fee asset
            $record[] = $line[11]; //fee amount
            $record[] = $line[14]; //comment (bitvavo address)
            break;
        case "buy":
            $record[] = "Trade";
            $record[] = $line[8]; //outgoing currency
            $record[] = abs($line[9]); //outgoing amount
            $record[] = $line[4]; //incoming asset
            $record[] = $line[5]; //incoming amount
            $record[] = $line[10]; //fee asset
            $record[] = $line[11]; //fee amount
            $record[] = $line[14]; //comment (bitvavo address)
            break;
        case "manually_assigned_bitvavo":
            $record[] = "Airdrop";
            $record[] = ""; //outgoing currency
            $record[] = ""; //outgoing amount
            $record[] = $line[4]; //incoming asset
            $record[] = $line[5]; //incoming amount
            $record[] = ""; //fee asset
            $record[] = ""; //fee amount
            $record[] = ""; //comment (bitvavo address)
            break;
        case "affiliate":
            $record[] = "Bounty";
            $record[] = ""; //outgoing currency
            $record[] = ""; //outgoing amount
            $record[] = $line[4]; //incoming asset
            $record[] = $line[5]; //incoming amount
            $record[] = ""; //fee asset
            $record[] = ""; //fee amount
            $record[] = ""; //comment (bitvavo address)
            break;
    }
    $record[] = $line[13]; //trx.ID
    $finalData[] = $record;
}


$finalFile = fopen("blockpit.csv","w");

foreach ($finalData as $finalDataLine) {
    fputcsv($finalFile, $finalDataLine);
}

fclose($finalFile);

echo 'Done';