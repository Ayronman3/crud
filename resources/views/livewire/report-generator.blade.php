<div>
    <button wire:click="generatePreview">Generate Preview</button>
    
    @if($reportPreview)
        <iframe src="{{ $reportPreview }}" width="100%" height="500px"></iframe>
        <button wire:click="downloadExcel">Download Excel</button>
        <button wire:click="downloadPDF">Download PDF</button>
    @endif
    @if($data)
    <h3>Data from Excel File:</h3>
    <table>
        @foreach($data as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endif
</div>