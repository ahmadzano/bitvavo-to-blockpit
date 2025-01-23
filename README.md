# Bitvavo-to-Blockpit

After migrating Bitvavo account from legacy to Bitvavo powered by Hyphe, you will have to close your old account and open a new one. 

Thankfully you can install a full history from your old account as a CSV. Unfortunately this file needs to be adjusted to be imported to Blockpit manually.

This script also converts the time zone to UTC as required by Blockpit. 

Here is the official article from Blockpit:
https://help.blockpit.io/hc/en-us/articles/360011877920-How-to-import-my-CSV-Excel-history


### Usage:
- Clone the repository or download just the `main.php` file
- Copy the Bitvavo file to same folder of `main.php` and name it `bitvavo.csv`
- Install PHP locally. No minimum version needed
- Run in the terminal `php main.php`
- If everything goes well, a new file `blockpit.csv` will be created which can be imported to Blockpit


You may need to adjust the generated file for special cases. In my case where a sell was set to `0€` by Bitvavo, I had to set adjust it to `0.01€`

