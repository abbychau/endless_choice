function showPath() {

}

function ec_embed(target, a) {
    $.get(
        'check.php?worldid=' + worldId + '&id=' + a, {
        key: ec_tokey[a]
    }, function(rtn) {
        autoPushVar();
        $('#' + target).html(rtn)
    });
}

function ec_get(dom) {
    if (document.getElementById(dom) == null) {
        console.log("no dom:" + dom);
    } else {
        return document.getElementById(dom).value;
    }
}

function ec_set(dom, val) {
    if (document.getElementById(dom) == null) {
        console.log("no dom:" + dom);
    } else {
        document.getElementById(dom).value = val;
    }
}

function ec_add(strvar, amount) {
    var prevVal = parseFloat(ec_get(strvar));
    if (isNaN(prevVal)) {
        prevVal = 0;
    }
    ec_set(strvar, prevVal + amount);
}

function ec_setChoiceTarget(choice, val) {
    $("#choice" + choice).attr("to", val)
}
var app_trophyID = "";

function getTrophy() {
    return app_trophyID;
}
var app_willVibrate = "NO";

function getVibration() {
    return app_willVibrate;
}
var app_hint = "";

function getHint() {
    return app_hint;
}
var app_admob_id = "";

function getAds() {
    return app_admob_id;
}

function ec_app(function_name, function_args) {
    if (function_name == "vibrate") {
        app_willVibrate = "YES";
    }
    if (function_name == "ads_interstitial") {
        app_admob_id = app_admod_interstitial;
    }
    if (function_name == "trophy") {
        app_trophyID = app_trophyID + ',' + function_args;
    }
    if (function_name == "hint") {
        app_hint = function_args;
    }
}

function ec_write(dom) {
    document.write(document.getElementById(dom).value);
}

function dwrite(str) {
    document.write(str);
}

function ec_push(dom_id, val) {
    $('[id=' + dom_id + ']').html(val);
}

function ec_show(dom) {
    $('[id="' + dom + '"]').css('display', 'inline');
}

function ec_hide(dom) {
    $('[id="' + dom + '"]').hide();
}

function ec_hideall(dom) {
    $(dom).hide();
}

function ec_dice(num) {
    return Math.floor(Math.random() * num) + 1;
}

function ec_hide_option(id) {
    $('#c' + id).hide();
}

function ec_lazy_push(arr) {
    for (var i = 0; i < arguments.length; i++) {
        ec_push(arguments[i], ec_get(arguments[i]));
    }
}

function ecPreviousPage() {
    return ec_get("ec_previous_page");
}

function ecThisPage() {
    return id;
}



function ec_setTheme(theme) {
    setCookie("ec_theme", theme, 9999);
    $("#theme_css").attr("href", "theme_css/" + theme + ".css");
}

function ecPreviousButtonId() {
    return buttonId;
}

function ec_setTitle(str) {
    $(".pagetitle").html(str);
}

function ec_hideOption(id) {
    if (Array.isArray(id)) {
        $.each(id, function(index, value) {
            ec_hideOption(value);
        });
    } else {
        $("#choice" + id).hide();
    }
}

function ec_showOption(id) {
    if (Array.isArray(id)) {
        $.each(id, function(index, value) {
            ec_showOption(value);
        });
    } else {
        $("#choice" + id).show();
    }
}

function ec_passed(id) {
    return (ec_get("ec_passed").indexOf("|" + id + "|") >= 0);
}