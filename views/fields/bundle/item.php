
<li class="cuztom-sortable__item" v-for="item in list" track-by="$index">
    <div class="cuztom-sortable__item__control">
        <div class="cuztom-sortable__item__handle">
            <a href="#"></a>
        </div>

        <div class="cuztom-sortable__item__remove"><a href="#"></a></div>
    </div>

    <fieldset class="cuztom-fieldset">
        <table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">
            {{{ item }}}
        </table>
    </fieldset>
</li>
