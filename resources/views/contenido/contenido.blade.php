@extends('principal')
@section('contenido')

    @if(Auth::check())
        @if(Auth::user()->idrol == 1)
            <template v-if="menu==0">
                
            </template>
            <template v-if="menu==1">
                <categoria></categoria>
            </template>
            <template v-if="menu==2">
                <producto></producto>
            </template>
            <template v-if="menu==3">
            <entrada></entrada>
            </template>
            <template v-if="menu==4">
                <salida></salida>
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
            <template v-if="menu==9">
                <consultaentrada></consultaentrada>
            </template>

            <template v-if="menu==10">
                <consultasalida></consultasalida>
            </template>

            <template v-if="menu==12">
                <informacion></informacion>
            </template>

        @elseif(Auth::user()->idrol == 2)
            <template v-if="menu==0">
                    
            </template>
            <template v-if="menu==1">
                <categoria></categoria>
            </template>
            <template v-if="menu==2">
                <producto></producto>
            </template>
            <template v-if="menu==3">
            <entrada></entrada>
            </template>
            <template v-if="menu==4">
            <salida></salida>
            </template>
            <template v-if="menu==5">
                <proveedor></proveedor>
            </template>
            <template v-if="menu==6">
                <cliente></cliente>
            </template>

            <template v-if="menu==9">
                <consultaentrada></consultaentrada>
            </template>
            <template v-if="menu==10">
                <consultasalida></consultasalida>
            </template>
            <template v-if="menu==12">
                <informacion></informacion>
            </template>
        @else

        @endif
    @endif

   
        
    @endsection