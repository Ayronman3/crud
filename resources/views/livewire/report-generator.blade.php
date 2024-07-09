<div>
    <button wire:click="generatePreview">Generate Preview</button>
    
    @if($reportPreview)
        <iframe src="{{ $reportPreview }}" width="100%" height="500px"></iframe>
        <button wire:click="downloadExcel">Download Excel</button>
        <button wire:click="downloadPDF">Download PDF</button>
    @endif
</div>