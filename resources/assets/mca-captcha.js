(function () {
  function activate(tab) {
    var driver = document.getElementById('mcaCapDriver');
    if (driver) driver.value = tab;

    document.querySelectorAll('[data-mca-cap-tab]').forEach(function (btn) {
      btn.classList.toggle('is-active', btn.getAttribute('data-mca-cap-tab') === tab);
    });

    document.querySelectorAll('[data-mca-cap-panel]').forEach(function (panel) {
      panel.classList.toggle('is-active', panel.getAttribute('data-mca-cap-panel') === tab);
    });
  }

  document.querySelectorAll('[data-mca-cap-tab]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      activate(btn.getAttribute('data-mca-cap-tab'));
    });
  });
})();
