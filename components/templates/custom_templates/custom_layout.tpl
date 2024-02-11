{capture assign=ContentBlock}
    {$ContentBlock}
    <div class="modal fade" data-user_id="{$user_id}" id="notification" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Attention !</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 13px;"><strong>Vous avez atteint le nombre maximum de jours de congés alloués pour cette année (fixé à 22 jours par année). Par conséquent, vous ne pouvez plus faire de demandes de congé annuelles supplémentaires pour le moment.</strong></p>
                </div>
                <div class="modal-footer" style="padding: 13px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-appear_per_login="{$count_reload_page}" id="notification_2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Attention !</h4>
                </div>
                <div class="modal-body">
                    <p><strong> Les utilisateurs qui ont consommé la totalité de leur Solde de Congé Sont </strong></p>
                    {foreach item=user key=key_user from=$users}
                        <p style="font-size: 13px; margin-left: 40px;">
                            <strong> <span style="text-decoration: underline;">{$user.Nom}</span> <span style="text-decoration: underline;">{$user.Prenom}</span> de N° <span style="text-decoration: underline;">{$user.Num}</span> </strong>
                        </p>
                    {/foreach}
                </div>
                <div class="modal-footer" style="padding: 13px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-count_solde_null="{$count_solde_null}" id="notification_3" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Attention !</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 13px;"><strong>Il savère qu'il y a <span style="text-decoration: underline;">{$count_solde_null} utilisateurs</span> avec un solde NULL (non Valide). Veuillez attribuer à chacun d'entre eux un solde valide afin de prévenir tout dysfonctionnement de l'application.</strong></p>
                </div>
                <div class="modal-footer" style="padding: 13px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-user_id="{$user_id}" id="notification_4" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Attention !</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 13px;"><strong>Il savère que votre solde de congé n'est pas valide (Solde NULL). Par conséquent, vous ne pouvez pas faire de demandes de congé pour le moment. Veuillez contacter l'admin pour régler ce problème. </strong></p>
                </div>
                <div class="modal-footer" style="padding: 13px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <form id="formulaire" name="formulaire" enctype="multipart/form-data" method="post" action="importation.php">
        <div class="modal fade" id="importation" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Importer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group form-group-label col-sm-3">
                                <label class="control-label"  data-column="Fichier_à_impoter">
                                    Fichier à impoter
                                    <span class="required-mark" style="display: none">*</span>
                                </label>
                            </div>
                            <div class="form-group col-sm-9">
                                <div class="col-input" style="width:100%;max-width:100%" data-column="Fichier_à_impoter">
                                    <input type="hidden" name="statut_edit_action" value="Keep">
                                    <div class="file-upload-control">
                                        <input name="file" data-pgui-legacy-validate="true" data-editor="imageuploader" data-field-name="Fichier_à_impoter" type="file" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="modal-footer" style="padding: 13px">
                        <a href="#" class="btn btn-primary" name="envoyer" id="envoyer" onClick="submitForm(event)">envoyer</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> 
    </form>
    <div class="modal fade" id="notification_decision" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Télécharger la décision</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 13px;"><strong>Veuillez télécharger la décision établie concernant <span id="DecisionUserPrenom" style="text-decoration: underline;" >DecisionUserPrenom</span> <span id="DecisionUserNom"style="text-decoration: underline;">DecisionUserNom</span> en date du <span id="DateDecision" style="text-decoration: underline;">DateDecision.</span></strong></p>
                </div>
                <div class="modal-footer" style="padding: 13px">
                    <a href="#" class="btn btn-primary" id="Telecharger" onclick="handleDownloadAttestationDecision(this)">Télécharger</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reloadPage()">Télécharger ultérieurement</button>
                </div>
            </div>
        </div>
    </div>
{/capture}

{include file='common/layout.tpl'}