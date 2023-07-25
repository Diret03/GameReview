$(document).ready(function () {
    // Agregar el evento de clic para el botón de comentario
    $(document).on('click', '.btn-comment', function () {
        var icon = $(this).find('i'); // Obtener el ícono del botón

        // Obtener el div del comentario
        var targetComment = $(this).data('target');

        // Alternar la animación de despliegue/colapso del comentario
        $(targetComment).slideToggle('fast', function () {
            // Verificar si el comentario está oculto o visible
            if ($(targetComment).is(':visible')) {
                // Si el comentario está visible, cambiar el ícono a 'fa-minus'
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                // Si el comentario está oculto, cambiar el ícono a 'fa-plus'
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });
});
