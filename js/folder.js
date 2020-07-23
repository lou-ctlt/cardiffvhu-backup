// Afficher le formulaire d'upload de nouvelles photos
if($('#photoform').is(":hidden")){
    $('#photo').click(function(){
        $('#photoform').removeAttr('hidden');
    });
}