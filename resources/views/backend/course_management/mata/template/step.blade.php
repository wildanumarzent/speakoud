
<div class="col-xl-3">
    <div class="card" style="overflow: hidden;">
        <div class="card-header"><h5 class="mb-0">Step Templating</h5></div>
        <div class="card-body">
            <a href="javascript:void();" class="media text-body px-3" style="{{ Request::segment(3) == 'mata' ? 'background-color:rgba(24,28,33,0.0) !important;' : '' }}">
                <div class="box-materi py-3">
                    <div class="dot-circle"></div>
                    <div class="media-body ml-3">
                        <h6 class="mb-1">Program Pelatihan</h6>
                        <div class="text-muted small"></div>
                    </div>
                </div>
            </a>
            <a href="javascript:void();" class="media text-body px-3" style="{{ Request::segment(3) == 'enroll' ? 'background-color:rgba(24,28,33,0.0) !important;' : '' }}">
                <div class="box-materi py-3">
                    <div class="dot-circle"></div>
                    <div class="media-body ml-3">
                        <h6 class="mb-1">Instruktur Enroll</h6>
                        <div class="text-muted small"></div>
                    </div>
                </div>
            </a>
            <a href="javascript:void();" class="media text-body px-3" style="{{ Request::segment(3) == 'materi' ? 'background-color:rgba(24,28,33,0.0) !important;' : '' }}">
                <div class="box-materi py-3">
                    <div class="dot-circle"></div>
                    <div class="media-body ml-3">
                        <h6 class="mb-1">Set Instruktur Mata Pelatihan</h6>
                        <div class="text-muted small"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
