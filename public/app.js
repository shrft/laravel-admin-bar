(function (w) {
    var icon   = w.document.getElementById('shrft-adminbar-minimized');
    var bar    = w.document.getElementById('shrft-adminbar-header');
    var clsBtn = w.document.getElementById('shrft-adminbar-header-close');
    var cls    = 'shrft-admin-bar-hide';

    var state_key = 'shrft-admin-bar-open';

    var expandAdminBar = function(){
        bar.classList.remove(cls);
        rememberState(true);
    };
    var minimizeAdminBar = function(){
        bar.classList.add(cls);
        rememberState(false);
    };
    var rememberState = function(isOpen){
        if (typeof (Storage) === "undefined") return;
        localStorage.setItem(state_key, isOpen);
    };
    var restoreState = function(){
        if (typeof (Storage) === "undefined") return;
        var state = localStorage.getItem(state_key) || 'true';
        if(state === 'true'){
            expandAdminBar();
            return;
        }
        minimizeAdminBar();
    }

    // expand adminbar
    icon.addEventListener('click', function () {
        expandAdminBar();
    });
    // minimize adminbar
    clsBtn.addEventListener('click', function () {
       minimizeAdminBar();
    });
    restoreState();
})(window);