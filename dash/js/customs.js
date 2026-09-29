//Get P/L (logic moved to blade where settings and auth are available)
/*
function GetPL() {
   // ...
}
*/

var badWords = [
    "<!--Start of Tawk.to Script-->",
    '<script type="text/javascript">',
    "<!--End of Tawk.to Script-->",
];
$(":input").on("blur", function () {
    var value = $(this).val();
    $.each(badWords, function (idx, word) {
        value = value.replace(word, "");
    });
    $(this).val(value);
});

$(document).ready(function () {
    $("#ShipTable").DataTable({
        order: [[0, "desc"]],
        dom: "Bfrtip",
        buttons: ["copy", "csv", "print", "excel", "pdf"],
    });
});

$("#usernameinput").on("keypress", function (e) {
    return e.which !== 32;
});

$(document).ready(function () {
    $(".UserTable").DataTable({
        order: [[0, "desc"]],
    });
});

let trademode = document.getElementById("trademode");
let msgbox = document.getElementById("msgbox");
let optionTitle = document.getElementById("optionTitle");
let optionInput = document.getElementById("optionInput");
let optionSelected = document.getElementById("optionSelected");

if (trademode) {
    function tradeSizeMsgs() {
        if (trademode.value == "none") {
            if (optionSelected) optionSelected.style.display = "none";
            if (msgbox) msgbox.value = "If value is none, then trade size will be preserved irregardless of the subscriber balance.";
        } else if (trademode.value == "balance") {
            if (optionSelected) optionSelected.style.display = "none";
            if (msgbox) msgbox.value = "If set to balance, the trade size on strategy subscriber will be scaled according to balance to preserve risk.";
        } else if (trademode.value == "equity") {
            if (optionSelected) optionSelected.style.display = "none";
            if (msgbox) msgbox.value = "If set to equity, the trade size on strategy subscriber will be scaled according to subscriber equity.";
        } else if (trademode.value == "contractSize") {
            if (optionSelected) optionSelected.style.display = "none";
            if (msgbox) msgbox.value = "If value is contractSize, then trade size will be scaled according to contract size.";
        } else if (trademode.value == "fixedVolume") {
            if (optionSelected) optionSelected.style.display = "block";
            if (optionTitle) optionTitle.innerText = "Enter Fixed trade volume";
            if (msgbox) msgbox.value = "If fixedVolume is set, then trade will be copied with a fixed volume of tradeVolume setting.";
        } else if (trademode.value == "fixedRisk") {
            if (optionSelected) optionSelected.style.display = "block";
            if (optionTitle) optionTitle.innerText = "Enter Fixed risk fraction";
            if (msgbox) msgbox.value = "Note, that in fixedRisk mode trades without a SL are not copied.";
        } else if (trademode.value == "expression") {
            if (optionSelected) optionSelected.style.display = "block";
            if (optionTitle) optionTitle.innerText = "Enter math.js expression";
            if (msgbox) msgbox.value = "Note, that expression trade size scaling mode is intended for advanced users and we DO NOT RECOMMEND using it unless you understand what are you doing, as mistakes in expression can result in loss.";
        }
    }
    
    trademode.addEventListener("change", tradeSizeMsgs);
    if (optionSelected) {
        optionSelected.style.display = "none";
    }
    tradeSizeMsgs();
}
