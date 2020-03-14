@php($no = $eventit->perPage() * $eventit->currentPage() - $eventit->perPage() + 1)
@foreach ($eventit as $item)    
<tr>
    <td align="center">{{ $no }}</td>
    <td>{{ $item->title }}</td>
    <td>{{ date('H:i | d F Y', strtotime($item->start)) }}</td>
    <td>{{ date('H:i | d F Y', strtotime($item->end)) }}</td>
    <td class="action">
        <div class="dropdown-primary dropdown open btn-block">
            <button class="btn btn-primary btn-sm btn-block dropdown-toggle" type="button" id="action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="feather icon-cpu"></i> Action
            </button>
            <div class="dropdown-menu" aria-labelledby="action" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                <a class="dropdown-item" onclick="edit({{ $item->id }})">
                    <i class="feather icon-edit"></i> Edit
                </a>
                <a class="dropdown-item" onclick="deleted({{ $item->id }})">
                    <i class="feather icon-trash"></i> Delete
                </a>
            </div>
        </div>
    </td>
</tr>
@php($no = $no + 1)
@endforeach

@if ($eventit->total() < 1)
<tr>
    <td colspan="5" align="center">Data not found</td>
</tr>
@endif

<script>
(function() {
    @if ($eventit->lastPage() > 1)
        $('#pagination').html(`{{ $eventit->links('components.pagination.ajax') }}`)
    @else
        $('#pagination').html('')
    @endif
})()
</script>