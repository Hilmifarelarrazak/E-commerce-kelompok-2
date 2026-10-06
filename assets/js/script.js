// Tombol [-] [+] untuk jumlah barang
document.querySelectorAll('.qty').forEach(function (box) {
  var input = box.querySelector('input');
  box.querySelectorAll('button').forEach(function (b) {
    b.addEventListener('click', function () {
      var v = parseInt(input.value || 1) + parseInt(b.dataset.step);
      var max = parseInt(input.max || 999);
      input.value = Math.max(1, Math.min(max, v));
    });
  });
});

// FAQ Accordion Toggle
document.querySelectorAll('.faq-question').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var item = btn.closest('.faq-item');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(function (el) {
      if (el !== item) el.classList.remove('open');
    });
    item.classList.toggle('open', !isOpen);
  });
});
