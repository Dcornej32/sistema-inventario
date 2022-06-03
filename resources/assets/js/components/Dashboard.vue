<template>
   <main class="main">
       <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
       </ol>
       <div class="container-fluid">
           <div class="card">
               <div class="card header">
               </div>
               <div class="card body">
                   <div class="row">
                       <div class="col-md-4">
                           <div class="card card-chart">
                               <div class="card-header">
                                   <h4>Productos</h4>
                               </div>
                               <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="stock" >
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Los 10 productos con menos stock</p>
                                </div>
                           </div> 
                       </div>
                       <div class="col-md-4">
                           <div class="card card-chart">
                               <div class="card-header">
                                   <h4>Entradas</h4>
                               </div>
                               <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="entradas" width="100" height="100">
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Entradas de los ultimos meses</p>
                                </div>
                           </div> 
                       </div>
                       <div class="col-md-4">
                           <div class="card card-chart">
                               <div class="card-header">
                                   <h4>Salidas</h4>
                               </div>
                               <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="salidas"  width="100" height="100">
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Salidas de los ultimos meses</p>
                                </div>
                           </div> 

                       </div>
                   </div>
               </div>
           </div>
       </div>
   </main>
</template>
<script>
import Axios from 'axios';

    export default {
        data() {
            return {
                varEntradas:null,
                charEntradas:null,
                entradas:[],
                varTotalEntradas:[],
                varMesEntradas:[],

                varSalidas:null,
                charSalidas:null,
                salidas:[],
                varTotalSalidas:[],
                varMesSalidas:[],

                varStock : null,
                charStock : null,
                stock: [],
                varNameStock:[],
                varCantidadStock: [], 
            }
        },
        methods: {
            async getFetch() {
                try {
                    const { data: { entradas, salidas, stock } } = await Axios.get('/dashboard');
                    this.salidas = salidas;
                    this.entradas = entradas;
                    this.stock = stock;
                    this.loadEntradas();
                    this.loadSalidas();
                    this.loadStock();
                } catch (error) {
                    console.error(error)
                }
            },
                
            loadEntradas(){
                let me = this;
                me.entradas.map(function(x){
                    
                    me.varMesEntradas.push(x.mes);
                    me.varTotalEntradas.push(x.total);
                });
                me.varEntradas=document.getElementById('entradas').getContext('2d');

                me.charEntradas = new Chart(me.varEntradas, {
                    
                    type: 'bar',
                    data: {
                        labels: me.varMesEntradas,
                        datasets: [{
                            label: 'Entradas',
                            data: me.varTotalEntradas,
                            backgroundColor: [
                                'rgb(75, 192, 192)',
                                'rgb(255, 99, 132)',
                                'rgb(255, 205, 86)',
                                'rgb(201, 203, 207)',
                                'rgb(54, 162, 235)'
                            ],                                
                            
                                
                            borderWidth: 1
                        }]
                    },
                    options: {
                       scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            loadSalidas(){
                let me = this;
                me.salidas.map(function(x){
                    me.varMesSalidas.push(x.mes);
                    me.varTotalSalidas.push(x.total);
                });
                me.varSalidas=document.getElementById('salidas').getContext('2d');

                me.charSalidas = new Chart(me.varSalidas, {
                    
                    type: 'bar',
                    data: {
                        labels: me.varMesSalidas,
                        datasets: [{
                            label: 'Salidas',
                            data: me.varTotalSalidas,
                            backgroundColor: [
                                'rgb(255, 205, 86)',
                                'rgb(255, 99, 132)',
                                'rgb(75, 192, 192)',
                                'rgb(201, 203, 207)',
                                'rgb(54, 162, 235)'
                            ],                                
                            
                                
                            borderWidth: 1
                        }]
                    },
                    options: {
                       scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            loadStock(){
                let me = this;
                me.stock.map(function(x){
                    me.varNameStock.push(x.nombre);
                    me.varCantidadStock.push(x.stock);
                    
                });
                me.varStock=document.getElementById('stock').getContext('2d');

                me.charStock = new Chart(me.varStock, {
                    
                    type: 'doughnut',
                    data: {
                        labels: me.varNameStock,
                        datasets: [{
                            label: 'stock',
                            data: me.varCantidadStock,
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(75, 192, 192)',
                                'rgb(255, 205, 86)',
                                'rgb(201, 203, 207)',
                                'rgb(54, 162, 235)'
                            ],                                
                            
                                
                            hoverOffset: 4
                        }]
                    },
                    
                });
            },

            
        },
        mounted() {
            this.getFetch()
        },
    }

</script>