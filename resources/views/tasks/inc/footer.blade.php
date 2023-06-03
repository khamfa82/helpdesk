<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <!-- <b>{!! Lang::get('lang.version') !!}</b> {!! Config::get('app.version') !!} -->
    </div>
    <?php
    $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
    ?>
    <strong>{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  
        <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>.
    </strong> 
    {!! Lang::get('lang.all_rights_reserved') !!}. 

    <!-- {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a> -->
</footer>