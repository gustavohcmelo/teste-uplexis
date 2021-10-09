<template>
    <div class="container">
        <form id="form-search" :action="route" method="GET">
            <div class="form-group mt-5 position-relative">
                <input type="text" class="form-control" id="termo" name="termo" aria-describedby="emailHelp" required>
                <small id="formtext" class="form-text text-muted">Digite alguma caracteristica do carro que deseja encontrar.</small>
                <button type="submit" class="btn-search position-absolute">
                   <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['route']
    }
</script>
