<svg viewBox="0 0 48 48" enable-background="new 0 0 48 48" class="hide">
    <defs>
        <symbol id="icon-custom-filter">
            <path id="path0_fill" d="M 46.522 0L 0.0750411 0C -0.0269589 0 0.0580411 17.636 0.0190411 17.73C -0.0199589 17.824 0.00204105 17.934 0.0750411 18.005L 17.57 35.406L 17.57 47.747C 17.57 47.888 17.683 48 17.822 48L 28.775 48C 28.914 48 29.027 47.888 29.027 47.747L 29.027 35.408L 46.522 18.005C 46.595 17.933 46.617 17.824 46.578 17.73C 46.538 17.635 46.522 0 46.522 0Z"/>
        </symbol>
    </defs>
</svg>

<div class="custom-filter-container">
    <form class="js-custom-filter-container" method="get">
        <ul class="nav nav-pills pull-right grid-card-column-filter">
            <li <?php if ($this->_tpl_vars['DemandeCongeFilterActive']): ?>class="active"<?php endif; ?>>
                <a href="#" class="js-filter-trigger" title="">
                    <svg viewBox="0 0 48 48" class="svg-icon">
                        <use xlink:href="#icon-custom-filter"></use>
                    </svg>&nbsp;Filtrer les décisions
                </a>
                <div class="js-content hide">
                    <div class="form-group">
                        <table width="100%">
                            <tr>
                                <td width="45%">
                                    <label for="Nom">Nom</label>
                                    <input type="text" data-editor="text" id="Nom" class="form-control input-sm" value="<?php echo $this->_tpl_vars['DemandeCongeFilter']['Nom']; ?>
">
                                </td>
                                <td width="10%">&nbsp;</td>
                                <td width="45%">
                                    <label for="Prenom">Prénom</label>
                                    <input type="text" data-editor="text" id="Prenom" class="form-control input-sm" value="<?php echo $this->_tpl_vars['DemandeCongeFilter']['Prenom']; ?>
">
                                </td>
                            </tr>
                            <tr>
                <td colspan="3">
                    <label for="DateDemande">Date de demande</label>
                    <input id="DateDemande" data-editor="datetime" data-pgui-legacy-validate="true" class="form-control" type="date" value="<?php echo $this->_tpl_vars['DemandeCongeFilter']['DateDemande']; ?>
" data-picker-format="DD-MM-YYYY" data-picker-show-time="false">
                </td>
            </tr>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div>

<script type="text/html" id="custom_filter_content">
    <div class="custom_filter">
        <button data-dismiss="alert" class="close" type="button">&times;</button>
        <div class="js-content"></div>
        <hr class="custom_filter_separator">
        <div class="btn-toolbar pull-right custom_filter_toolbar">
            <button type="button" class="btn btn-sm btn-primary js-apply">Apply</button>
        </div>
        <div class="clearfix"></div>
    </div>
</script>