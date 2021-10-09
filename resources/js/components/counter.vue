<template>
<div id="main">
    <div class="container counter">
        <div class="circle">
            <div class="numbers">
                <div>
                    <h1>{{ founds }}</h1>
                    <h5>veículos encontrados</h5>
                    <a :href="list">mostrar todos</a>
                </div>
            </div>
        </div>
    </div>
    <a :href="home" class="btn btn-default">Página Inicial</a>
</div>
</template>

<script>
export default {
    props: ['founds', 'home', 'list'],
    mounted(){
        /* setInterval(() => {
            this.counter += 10
        },1000) */
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
#main{
    text-align: center;
}
.counter{
    margin: 4vh auto;
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.circle{
    width: 300px;
    height: 300px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba( 255, 255, 255, 0.25 );
    box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
    backdrop-filter: blur( 3.5px );
    -webkit-backdrop-filter: blur( 3.5px );
    border-radius: 10%;
    border: 1px solid rgba( 255, 255, 255, 0.18 );
}
.numbers h1{
    text-align: center;
    font-size: 8rem;
    color: #4535d9;
    font-family: 'Roboto', sans-serif;
}
.numbers h5{
    text-align: center;
    color: #4535d9;
    font-family: 'Roboto', sans-serif;
}
.numbers a{
    display: block;
    text-align: center;
    font-weight: 600;
    color: #4535d9;
}
</style>