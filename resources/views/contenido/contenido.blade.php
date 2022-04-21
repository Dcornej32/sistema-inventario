@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        
    </template>
    <template v-if="menu==1">
        <categoria></categoria>
    </template>
    <template v-if="menu==2">
        <H1>Contenido Menú 2</H1>
    </template>
    <template v-if="menu==3">
        <H1>Contenido Menú 3</H1>
    </template>
    <template v-if="menu==4">
        <H1>Contenido Menú 4</H1>
    </template>
    <template v-if="menu==5">
        <H1>Contenido Menú 5</H1>
    </template>
    <template v-if="menu==6">
        <H1>Contenido Menú 6</H1>
    </template>
        
    @endsection