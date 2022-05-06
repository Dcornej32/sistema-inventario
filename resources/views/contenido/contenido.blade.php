@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        
    </template>
    <template v-if="menu==1">
        <categoria></categoria>
    </template>
    <template v-if="menu==2">
        <producto></producto>
    </template>
    <template v-if="menu==3">
        <H1>Contenido Menú 3</H1>
    </template>
    <template v-if="menu==4">
        <H1>Contenido Menú 4</H1>
    </template>
    <template v-if="menu==5">
        <proveedor></proveedor>
    </template>
    <template v-if="menu==6">
        <cliente></cliente>
    </template>

    <template v-if="menu==7">
        <user></user>
    </template>
    <template v-if="menu==8">
        <rol></rol>
    </template>

    <template v-if="menu==12">
        <informacion></informacion>
    </template>
        
    @endsection