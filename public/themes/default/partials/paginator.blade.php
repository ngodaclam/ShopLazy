@if($paginator->hasPages())
    <div class="col-md-6">
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
            {!! paginator($paginator) !!}
        </div>
    </div>
@endif