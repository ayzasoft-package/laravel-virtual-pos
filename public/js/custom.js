$(document).ready(function(){
    let ccNumberMask = new Inputmask("9999 9999 9999 9999");
ccNumberMask.mask(document.getElementById("cc-number"));

let ccExpiryMask = new Inputmask("99 / 9999");
ccExpiryMask.mask(document.getElementById("cc-expiry"));

});