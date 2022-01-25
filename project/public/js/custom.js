$(document).ready(function() {
    let sidebarBtn = document.getElementById('sidebar-toggler');
    let headerSidebarBtn = document.getElementById('header-sidebar-btn');

    let toggleSidebar = function () {
        let sidebarNode = document.querySelector('#sidebar');
        let sidebar = coreui.Sidebar.getInstance(sidebarNode);
        let element = sidebar._element;

        console.log(element);
        if (!element.classList.contains('show')) {
            $(element).removeClass('hide').addClass('show');
            sidebar.show();
        } else {
            $(element).removeClass('show').addClass('hide');
            sidebar.hide();
        }
    };

    sidebarBtn.addEventListener('click', toggleSidebar);
    headerSidebarBtn.addEventListener('click', toggleSidebar);

    $('#appointment-datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    });
});