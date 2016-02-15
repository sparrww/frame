function checkAll() {
    for (var j = 1; j <= 1000; j++) {
        box = eval("document.checkboxform.record" + j);
        if (box.checked == false) box.checked = true;
    }
}

function uncheckAll() {
    for (var j = 1; j <= 1000; j++) {
        box = eval("document.checkboxform.record" + j);
        if (box.checked == true) box.checked = false;
    }
}

function switchAll() {
    for (var j = 1; j <= 1000; j++) {
        box = eval("document.checkboxform.record" + j);
        box.checked = !box.checked;
    }
}/**
 * Created by Administrator on 2015/10/10.
 */
