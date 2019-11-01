# Ransomware

PHP ransomware that encrypts your files as well as file and directory names.

Ransomware is set to start encrypting files and directories from the server's web root directory and only inside the server's web root directory.

Tested on XAMPP for Windows v7.3.7 (64 bit) with PHP v7.3.7.

Made for educational purposes. I hope it will help!

## How to Run

**Care not to do damage! Backup your server files before running ransomware!**

Copy ['\\src\\encrypt.php'](https://github.com/ivan-sincek/ransomware/blob/master/src/encrypt.php) to your server's web root directory (e.g. '\\xampp\\htdocs\\' on XAMPP).

Decryption file will be created automaticly after the encryption phase.

Navigate to the encryption file with your preferred web browser.

In case you forgot your encryption key, you can find it hardcoded inside the decryption page. View the page source code in your web browser and search for the keyword `recovery`, there you will find your encryption/decryption key.

## Images

![Ransomware](https://github.com/ivan-sincek/ransomware/blob/master/img/ransomware.jpg)

![Encrypted](https://github.com/ivan-sincek/ransomware/blob/master/img/encrypted.jpg)
