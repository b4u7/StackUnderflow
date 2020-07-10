function copyCurrentUrl() {
    let dummy = document.createElement('input');
    dummy.className = 'hidden';

    let url = window.location.href;

    document.body.appendChild(dummy);

    dummy.value = url;
    dummy.select();

    document.execCommand('copy');
    document.body.removeChild(dummy);
}

document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('actionShare').onclick = copyCurrentUrl;
});
