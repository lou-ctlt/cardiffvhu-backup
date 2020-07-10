// Recherche d'un dossier
$("#searchbar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".linkToFolder").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// Afficher le formulaire d'ajout de dossier
if($('#folderform').is(":hidden")){
    $('#folder').click(function(){
        $('#folderform').removeAttr('hidden');
    });
};