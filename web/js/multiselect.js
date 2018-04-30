$(document).ready(function() {
    //MultiSelect de tipo recetas
    $('.multiselect').multiselect({
        buttonClass: 'custom-select',
        buttonWidth: '100%',
        nonSelectedText: 'Tipo',
        allSelectedText: 'Todo seleccionado',
        dropRight: true
    });
    $('.multiselect-native-select').removeClass("dropdown-toggle");
});