function handleDownloadAttestationTravail(button) {
    var Langue = button.getAttribute("data-lang");
    var url_php_1 = "handleSendAttestationTravailArabe.php";
    var url_php_2 = "handleSendAttestationTravailFrancais.php";
    var userId = button.getAttribute("data-user_id"); 
    var requestData = {
        userID: userId
    };

    if (Langue == 'French') {
        $.ajax({
             url: url_php_2,
             type: 'POST',
             data: requestData,
             dataType: 'json',
             success: function(dataResult) {
                 var infos = dataResult;
                 var url_html = "test7.html?" + Math.random();
                 infos.forEach(info => {
                     var Prenom = info.Prenom;
                     var Nom = info.Nom;
                     var Grade = info.Grade;
                     var CIN = info.CIN;
                     var Corps = info.Corps
                     var MatriculeAujour = info.MatriculeAujour;

                     fetch(url_html)
                         .then(response => response.text())
                         .then(html => {
                              var modifiedHtml = html.replace('secondName', Nom)
                                  .replace('firstName', Prenom)
                                  .replace('Gd', Grade)
                                  .replace('Crp', Corps)
                                  .replace('CarteNational', CIN)
                                  .replace('MatrAujour', MatriculeAujour);
                                 
                    
                              var iframe = document.createElement("iframe");
                              iframe.style.display = "none";
                              document.body.appendChild(iframe);

                              var iframeDoc = iframe.contentWindow.document;
                              iframeDoc.open();
                              iframeDoc.write(modifiedHtml);
                              iframeDoc.close();

                              iframe.onload = function() {
                                   iframe.contentWindow.print();
                                   document.body.removeChild(iframe);
                              };
                         })
                        .catch(error => {
                              console.error("Error fetching HTML:", error);
                        });

                 });
        },
             error: function(jqXHR, textStatus, errorThrown) {
                  console.error("AJAX Error:", errorThrown);
             }
       });
    }
    if (Langue == 'Arabic') {
        $.ajax({
             url: url_php_1,
             type: 'POST',
             data: requestData,
             dataType: 'json',
             success: function(dataResult) {
                 var infos = dataResult;
                 var url_html = "test6.html?" + Math.random();
                 infos.forEach(info => {
                     var Prenom = info.Prenom_arabe;
                     var Nom = info.Nom_arabe;
                     var Grade = info.Grade_arabe;
                     var CIN = info.CIN;
                     var Corps = info.Corps_arabe;
                     var MatriculeAujour = info.MatriculeAujour;

                     fetch(url_html)
                         .then(response => response.text())
                         .then(html => {
                              var modifiedHtml = html.replace('Nom', Nom)
                                  .replace('Prenom', Prenom)
                                  .replace('Grade', Grade)
                                  .replace('Corps', Corps)
                                  .replace('CIN', CIN)
                                  .replace('Aujour', MatriculeAujour);
                                 
                    
                              var iframe = document.createElement("iframe");
                              iframe.style.display = "none";
                              document.body.appendChild(iframe);

                              var iframeDoc = iframe.contentWindow.document;
                              iframeDoc.open();
                              iframeDoc.write(modifiedHtml);
                              iframeDoc.close();

                              iframe.onload = function() {
                                   iframe.contentWindow.print();
                                   document.body.removeChild(iframe);
                              };
                         })
                        .catch(error => {
                              console.error("Error fetching HTML:", error);
                        });

                 });
        },
             error: function(jqXHR, textStatus, errorThrown) {
                  console.error("AJAX Error:", errorThrown);
             }
       });
    }
}

function handleDownloadDemandeAttestationTravail(button) {
    var Langue = button.getAttribute("data-lang");
    var userId = button.getAttribute("data-user_id"); 
    var requestData = {
        userID: userId
    };
    
    var url_php = "handleDownloadAttestationTravail.php";
    var userId = button.getAttribute("data-user_id"); 
    var requestData = {
        userID: userId
    };
    if (Langue == 'Arabic') {
        var choix_arabe = true;
        var choix_francais = false;
    } else if (Langue == 'French') {
           var choix_arabe = false;
           var choix_francais = true;
    }
    
    $.ajax({
        url: url_php,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(dataResult) {
            var infos = dataResult;
            var url_html = "test.html?" + Math.random();
            infos.forEach(info => {
                var Prenom_arabe = info.Prenom_arabe;
                var Nom_arabe = info.Nom_arabe;
                var Grade = info.Grade;
                var CIN = info.CIN;

                fetch(url_html)
                    .then(response => response.text())
                    .then(html => {
                        var modifiedHtml = html.replace('Nom_arabe', Nom_arabe)
                            .replace('Prenom_arabe', Prenom_arabe)
                            .replace('Grade', Grade)
                            .replace('CIN', CIN)
                            .replace('choix_arabe', choix_arabe)
                            .replace('choix_francais', choix_francais);
                    
                        var iframe = document.createElement("iframe");
                        iframe.style.display = "none";
                        document.body.appendChild(iframe);

                        var iframeDoc = iframe.contentWindow.document;
                        iframeDoc.open();
                        iframeDoc.write(modifiedHtml);
                        iframeDoc.close();

                        iframe.onload = function() {
                            iframe.contentWindow.print();
                            document.body.removeChild(iframe);
                        };
                    })
                    .catch(error => {
                         console.error("Error fetching HTML:", error);
                    });

            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", errorThrown);
        }
    });
}

function setAttributes(button) {
    var demandId = button.getAttribute("data-demande_id");
    var autorisation = button.getAttribute("data-autorisation");

    var TelechagerButton = document.getElementById("Telecharger");
    TelechagerButton.setAttribute("data-demande_id", demandId);
    TelechagerButton.setAttribute("data-autorisation", autorisation);
}

function reloadPage() {
    location.reload();
}

function handleDownloadAttestationConge(button) {
    var demandId = button.getAttribute("data-demande_id");
    var url_php = "handleDownloadAttestationCongeArabe.php";
    var requestData = {
        demandID: demandId
    };

    $.ajax({
        url: url_php,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        async: false,
        success: function(dataResult) {
            var infos = dataResult;
            var url_html = "test2.html?" + Math.random();
            infos.forEach(info => {
                var Grade_Status = "block";
                var Service_Status = "block";
                var Division_Status = "block";
                var Direction_Status = "block";
                var Nom_arabe = info.Nom_arabe;
                var Prenom_arabe = info.Prenom_arabe;
                var Grade = info.Grade;
                var Service = info.Service;
                var Division = info.Division;
                var Direction = info.Direction;
                var Date_de_demande = info.Date_de_demande;
                var Date_de_depart = info.Date_de_depart;
                var nbr_jours = parseInt(info.nbr_jours);
                var Autorisation = parseInt(info.Autorisation);
                var Type = info.Type;
                if (Grade == null) {
                    Grade_Status = "none";
                }
                if (Service == null) {
                    Service_Status = "none";
                }
                if (Division == null) {
                    Division_Status = "none";
                }
                if (Direction == null) {
                    Direction_Status = "none";
                }
                fetch(url_html)
                    .then(response => response.text())
                    .then(html => {
                        var modifiedHtml = html.replace('Grade', Grade)
                            .replace('Service', Service)
                            .replace('Division', Division)
                            .replace('Direction', Direction)
                            .replace('Date_de_demande', Date_de_demande)
                            .replace('Date_de_depart', Date_de_depart)
                            .replace('nbr_jours', nbr_jours)
                            .replace('auto_bool', Autorisation)
                            .replace('Nom_arabe', Nom_arabe)
                            .replace('Prenom_arabe', Prenom_arabe)
                            .replace('GStatus', Grade_Status)
                            .replace('SStatus', Service_Status)
                            .replace('DvStatus', Division_Status)
                            .replace('DrStatus', Direction_Status)
                            .replace('tpdemande', Type);
                            
                        var iframe = document.createElement("iframe");
                        iframe.style.display = "none";
                        document.body.appendChild(iframe);

                        // Écrire le contenu HTML dans l'iframe
                        var iframeDoc = iframe.contentWindow.document;
                        iframeDoc.open();
                        iframeDoc.write(modifiedHtml);
                        iframeDoc.close();

                        // Attendre le chargement de l'iframe, puis déclencher l'impression
                        iframe.onload = function() {
                            iframe.contentWindow.print();
                            // Supprimer l'iframe après l'impression
                            document.body.removeChild(iframe);
                        };
                    })
                    .catch(error => {
                        console.error("Erreur lors de la récupération du HTML :", error);
                    });
            });
        }
    });
}


function handleDownloadAttestationDecision(button) {
    var autorisation = parseInt(button.getAttribute("data-autorisation"));
    var demandId = parseInt(button.getAttribute("data-demande_id"));
    var url_php_1 = "handleDownloadAttestationCongeArabe.php";
    var url_php_2 = "handleDownloadAttestationCongeFrancais.php";
    var requestData = {
        demandID: demandId
    };
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    if (autorisation) {
        $.ajax({
             url: url_php_2,
             type: 'POST',
             data: requestData,
             dataType: 'json',
             success: function(dataResult) {
                 var infos = dataResult;
                 var url_html = "test8.html?" + Math.random();
                 infos.forEach(info => {
                     var Civilite = info.Civilite;
                     var nbr_jours = info.nbr_jours;
                     var Prenom = info.Prenom;
                     var Nom = info.Nom;
                     var Grade = info.Grade;
                     var date_de_retour = info.Date_de_retour;
                     var date_de_depart = info.Date_de_depart;

                     fetch(url_html)
                         .then(response => response.text())
                         .then(html => {
                              var modifiedHtml = html.replace('nbr_jours_1', parseInt(nbr_jours))
                                  .replace('nbr_jours_2', parseInt(nbr_jours))
                                  .replace('date_de_depart', '"' + date_de_depart + '"')
                                  .replace('date_de_retour', '"' + date_de_retour + '"')
                                  .replace('Civilite_1', Civilite)
                                  .replace('Prenom_1', Prenom)
                                  .replace('Nom_1', Nom)
                                  .replace('Grade', Grade)
                                  .replace('nbr_jours_3', parseInt(nbr_jours))
                                  .replace('Civilite_2', Civilite)
                                  .replace('Prenom_2', Prenom)
                                  .replace('Nom_2', Nom)
                                  .replace('year-1', year);
                              
                              var iframe = document.createElement("iframe");
                              iframe.style.display = "none";
                              document.body.appendChild(iframe);

                              var iframeDoc = iframe.contentWindow.document;
                              iframeDoc.open();
                              iframeDoc.write(modifiedHtml);
                              iframeDoc.close();

                              iframe.onload = function() {
                                   iframe.contentWindow.print();
                                   document.body.removeChild(iframe);
                              };
                         })
                        .catch(error => {
                              console.error("Error fetching HTML:", error);
                        });

                 });
        },
             error: function(jqXHR, textStatus, errorThrown) {
                  console.error("AJAX Error:", errorThrown);
             }
       });
    } else {
        $.ajax({
        url: url_php_1,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        async: false,
        success: function(dataResult) {
            var infos = dataResult;
            var url_html = "test3.html?" + Math.random();
            infos.forEach(info => {
                var Nom_arabe = info.Nom_arabe;
                var Prenom_arabe = info.Prenom_arabe;
                var Date_de_depart = info.Date_de_depart;
                var nbr_jours = parseInt(info.nbr_jours);
                fetch(url_html)
                    .then(response => response.text())
                    .then(html => {
                        var modifiedHtml = html.replace('nbr_jours1', nbr_jours)
                            .replace('nbr_jours2', nbr_jours)
                            .replace('nbr_jours3', nbr_jours)
                            .replace('Date_de_depart', '"' + Date_de_depart + '"')
                            .replace('Nom_arabe', Nom_arabe)
                            .replace('Prenom_arabe', Prenom_arabe)
                            .replace('year-1', year);
                        var iframe = document.createElement("iframe");
                        iframe.style.display = "none";
                        document.body.appendChild(iframe);

                        // Écrire le contenu HTML dans l'iframe
                        var iframeDoc = iframe.contentWindow.document;
                        iframeDoc.open();
                        iframeDoc.write(modifiedHtml);
                        iframeDoc.close();

                        // Attendre le chargement de l'iframe, puis déclencher l'impression
                        iframe.onload = function() {
                            iframe.contentWindow.print();
                            // Supprimer l'iframe après l'impression
                            document.body.removeChild(iframe);
                        };
                    })
                    .catch(error => {
                        console.error("Erreur lors de la récupération du HTML :", error);
                    });
            });
        }
    });
    }  
}


function importation_Canvas() {
const fileInput = document.querySelector('input[type="file"]');
const file = fileInput.files[0];

  if (file) {
    const formData = new FormData();
    formData.append('file', file);
    
    const url_php = "importation.php";

    fetch(url_php, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      // Gérer la réponse du serveur ici
      console.log('Réponse du serveur :', response);
    })
    .catch(error => {
      // Gérer les erreurs ici
      console.error('Erreur lors de l\'envoi du fichier au serveur :', error);
    });
  }
}

function submitForm(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien

    var form = document.getElementById('formulaire');
    form.submit(); // Soumet le formulaire
}


function createPopover() {
    $('[data-input-popover]').each(function(index, value) {
        $(this).data("toggle", "popover");
        $(this).data("trigger", "hover");        
        $(this).data("placement", "top");        
        $(this).data("content", $(this).data("input-popover"));
        $(this).popover();        
    });
}

require(['jquery'], function () {
    $(function () {
        createPopover();
    });
});