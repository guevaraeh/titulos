<link rel="stylesheet" href="https://unpkg.com/slim-select@latest/dist/slimselect.css" />
<style>
.ss-main .ss-arrow {
    display: none !important;
}
.ss-main .ss-single-selected {
    justify-content: flex-start !important; /* Elimina separación con la flecha */
}

.ss-main .ss-single {
    /*padding: var(--ss-spacing-s) var(--ss-spacing-m) var(--ss-spacing-s) var(--ss-spacing-m);*/
    margin: auto 0px auto 0px;
    line-height: 1em;
    align-items: center;
    width: 100%;
    /*overflow: hidden;*/
    /*text-overflow: ellipsis;*/
    white-space: nowrap;
}

.ss-main.ss-content {
    height: auto !important;
    width: auto !important;
    /*min-width: 600px !important;*/
    /*overflow: auto !important;*/
}

.ss-list {
  max-height: 240px; /* o el alto que desees */
  overflow-y: auto;
}

.ss-selected {
  background-color: var(--bs-primary) !important;
  color: #fff !important; /* Texto blanco para contraste */
}

.ss-option:hover {
  background-color: var(--bs-primary) !important;
  color: #fff !important;
}

.ss-option.ss-highlighted {
  background-color: var(--bs-primary) !important;
  color: #fff !important;
}

.ss-content .ss-search input {
    border-radius: var(--bs-border-radius)
}
.ss-content .ss-search input:focus {
    box-shadow: 0 0 5px var(--bs-primary);
}

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css" rel="stylesheet" integrity="sha384-BDXgFqzL/EpYeT/J5XTrxR+qDB4ft42notjpwhZDEjDIzutqmXeImvKS3YPH/WJX" crossorigin="anonymous">
<link href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.min.css" rel="stylesheet" integrity="sha384-seyUnB//1QOFEqox9uI7YTLBgz9jBwFRqZvsEPFrTw6NAsFEo70nhBWsQfODqiYA" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/libraries/bootstrap-styles/bootstrap-sandstone.min.css') }}">
