$(function(){
function translate(text)
{
  var from = 'zh-CHS'; //zh-CHS:簡易字中国語, zh-CHT:繁体字中国語
  var to = 'ja';

  $('.translate_addon').css('display', 'none');

  var s = document.createElement('script');
  s.src = 'http://skill.se-project.co.jp/translate/' +
    '?text=' + encodeURIComponent(text) +
    '&from=' + encodeURIComponent(from) +
    '&to=' + encodeURIComponent(to) +
    '&oncomplete=translatecallback';
  document.body.appendChild(s);
}

var script = document.createElement('script');
script.innerHTML = 
"function translatecallback(response){" +
"  var div = document.createElement('div');" +
"  div.className = 'translate_addon';" + 
"  div.style = 'left: ' + $('#pageX').val() + 'px; top: ' + $('#pageY').val() + 'px;';" +
"  div.innerHTML = response;" +
"  document.body.appendChild(div);" +
"}"
;
document.body.appendChild(script);

var style = document.createElement('style');
style.innerHTML = 
"div.translate_addon {" +
"  position: absolute;" + 
"  background-color: #ffffe1;" + 
"  border: 1px black solid;" + 
"  padding: 3px;" +
"}"
;
document.body.appendChild(style);

var screenx = document.createElement('input');
screenx.type = 'hidden';
screenx.id = 'pageX';
screenx.value = 0;
document.body.appendChild(screenx);

var screeny = document.createElement('input');
screeny.type = 'hidden';
screeny.id = 'pageY';
screeny.value = 0;
document.body.appendChild(screeny);

document.addEventListener(
  'mouseover',
  function(e){
    $('#pageX').val(e.pageX);
    $('#pageY').val(e.pageY);
    setTimeout(function() {
      if($('#pageX').val() == e.pageX && $('#pageY').val() == e.pageY) {
        var hover_elements = jQuery(":hover");
        var text = hover_elements[hover_elements.length - 1].innerText;
        translate(text);
      }
    }, 250);
  },
  false
);
});
