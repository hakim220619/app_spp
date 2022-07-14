<div id="toastsContainerTopRight" class="toasts-top-right fixed" style="min-width: 25%; z-index: 1000000">
    <div class="toast {{$alertTypeClasses[$alertType]}} fade"
         @toast-message-show.window="show=true; setTimeout(() => show=false, {{config('constants.toast.show-length', 2000)}});"
         x-data="{show:false}" :class="{'show': show === true }"
         x-cloak role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">{{$message}}</div>
    </div>
</div>
