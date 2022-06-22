function showHide(id) {
  var this_el = document.getElementById(id);
  var this_info = document.getElementById("info_" + (id.split("_"))[1]);
  var info = $('[id^="info_"]');
  var other_el = $('[id^="el_"]');

  if (!(this_el.classList.contains('open'))) {
    this_info.classList.remove('info_hide');

    for (var i = 0; i < other_el.length; i++) {
      other_el[i].classList.remove('open');
      other_el[i].style.backgroundColor = '#ffffff';
      other_el[i].style.boxShadow = '';
      other_el[i].style.border = '1px solid #000';

      info[i].style.display = 'none';
    }

    this_info.style.display = '';
    this_el.style.backgroundColor = '#e0e0e0';
    this_info.style.backgroundColor = '#e0e0e0';
    this_el.style.boxShadow = '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)';
    this_info.style.boxShadow = '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)';
    this_el.style.border = '2px solid #000';
    this_info.style.border = '2px solid #000';
    this_el.style.borderBottom = '2px solid #e0e0e0';
    this_el.classList.add('open');

  } else {
    this_el.classList.remove('open');
    this_el.style.backgroundColor = '#ffffff';
    this_el.style.boxShadow = '';
    this_el.style.border = '1px solid #000';
    this_info.classList.add('info_hide');

  }
}