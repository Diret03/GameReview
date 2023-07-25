$(document).ready(function () {
    // Agregar el evento de clic para el botón de comentario
    $('.btn-descripcion').click(function () {
        var icon = $(this).find('i'); // Obtener el ícono del botón

        // Verificar si el comentario está oculto o visible
        if ($(this).attr('aria-expanded') === 'true') {
            // Si el comentario está visible, cambiar el ícono a 'fa-plus'
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            // Si el comentario está oculto, cambiar el ícono a 'fa-minus'
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });

    // Agregar un evento para cuando se complete la animación de colapso/expandir
    $('.collapse').on('shown.bs.collapse hidden.bs.collapse', function () {
        var icon = $(this).prev('.btn-descripcion').find('i'); // Obtener el ícono del botón

        // Verificar si el comentario está oculto o visible
        if ($(this).hasClass('show')) {
            // Si el comentario está visible, cambiar el ícono a 'fa-minus'
            icon.removeClass('fa-plus').addClass('fa-minus');
        } else {
            // Si el comentario está oculto, cambiar el ícono a 'fa-plus'
            icon.removeClass('fa-minus').addClass('fa-plus');
        }
    });
});