$(document).ready( function () 
{
    count=1;
    $('.reportComment').click(function() 
        {
            event.preventDefault();
            var id = $(this).attr('id');
            var number = count;

            $.ajax
                ({
                    url: "/unwantedcomments",
                    type: 'POST',
                    data: {number:number, id:id}, // An object with the key 'submit' and value 'true;
                    success: function (result) 
                        {
                            alert('Le commentaire a été signalé');
                        }
                });  
        });
});