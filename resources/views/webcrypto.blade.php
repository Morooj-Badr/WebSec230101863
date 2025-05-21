@extends('layouts.master')
@section('title', 'Web Crypto')
@section('content')
<div class="container">
    <div class="card m-4">
        <div class="card-header">
            <h4>Web Crypto API Operations</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <label for="plain" class="form-label">Plain Text:</label>
                    <textarea id="plain" class="form-control" rows="3" required>Welcome to WebCrypto</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <button type="button" class="btn btn-primary" onclick="encryptCBC()">Encrypt</button>
                    <button type="button" class="btn btn-primary" onclick="decryptCBC()">Decrypt</button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="cipher" class="form-label">Cipher Text:</label>
                    <textarea id="cipher" class="form-control" rows="3" required></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const iv = window.crypto.getRandomValues(new Uint8Array(16));
let key = null;

// Generate AES key on page load
window.crypto.subtle.generateKey({
    name: "AES-CBC",
    length: 256,
}, true, ["encrypt", "decrypt"])
.then(function(key_) {
    key = key_;
    console.log("Key generated successfully");
})
.catch(function(error) {
    alert("Error generating key: " + error);
});

function encryptCBC() {
    const plain = document.getElementById("plain");
    const cipher = document.getElementById("cipher");
    const encodedText = new TextEncoder().encode(plain.value);
    
    window.crypto.subtle.encrypt({
        name: "AES-CBC",
        iv: iv,
    }, key, encodedText)
    .then(function(encryptedData) {
        const encryptedBase64 = btoa(String.fromCharCode(...new Uint8Array(encryptedData)));
        cipher.value = encryptedBase64;
    })
    .catch(function(error) {
        alert(error);
    });
}

function decryptCBC() {
    const plain = document.getElementById("plain");
    const cipher = document.getElementById("cipher");
    try {
        const encryptedData = Uint8Array.from(atob(cipher.value), c => c.charCodeAt(0));
        const decryptedData = window.crypto.subtle.decrypt({
            name: "AES-CBC",
            iv: iv,
        }, key, encryptedData)
        .then(function(decryptedData) {
            plain.value = new TextDecoder().decode(decryptedData);
        })
    }
    catch(error) {
        alert(error);
    }
}
</script>
@endsection 