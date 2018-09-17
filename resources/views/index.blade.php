@extends('layouts.header')

@section('content')
<div class="ui container">
    <img src="{{asset('img/ifce.png')}}" id="logoIfce"><h1 class="textoTopo">Projeto simulador de memória cache</h1>
    <div class="ui segment" id="divFormSegment">
        <form class="ui form" action="/processoCache" method="POST">
            {{ csrf_field() }}
            <h3 class="ui dividing header">Tamanho da memória cache</h3>
            <div class="ui segment">
                <div class="five fields">
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="cache[]" tabindex="0" class="hidden" value="1024">
                            <label>1024 bytes</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="cache[]" tabindex="0" class="hidden" value="2048">
                            <label>2048 bytes</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="cache[]" tabindex="0" class="hidden" value="4096">
                            <label>4096 bytes</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="cache[]" tabindex="0" class="hidden" value="8192">
                            <label>8192 bytes</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="cache[]" tabindex="0" class="hidden" value="16384">
                            <label>16384 bytes</label>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="ui dividing header">Bloco</h3>
            <div class="required field">
                <label>Tamanho</label>
                <select class="ui search dropdown" name="tamanhoBloco">
                    <option value="">Selecione o tamanho do bloco</option>
                    <option value="16">16 bytes</option>
                </select>
            </div>

            <h3 class="ui dividing header">Tipo de Mapeamento</h3>
            <div class="ui segment">
                <div class="four fields">
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="mapeamento[]" tabindex="0" class="hidden" value="1">
                            <label>Direto</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="mapeamento[]" tabindex="0" class="hidden" value="2">
                            <label>2-way</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="mapeamento[]" tabindex="0" class="hidden" value="4">
                            <label>4-way</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="mapeamento[]" tabindex="0" class="hidden" value="8">
                            <label>8-way</label>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="ui dividing header">Política de Substituição</h3>
            <div class="ui segment">
                <div class="two fields">
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="substituicao[]" tabindex="0" class="hidden" value="1">
                            <label>LRU - Least Recently Used</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="substituicao[]" tabindex="0" class="hidden" value="0">
                            <label>FIFO - First In, First Out</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field" id="botoes">
                <button type="submit" class="positive ui button" id="btnEnviar">
                    Simular Cache
                </button>
            </div>
        </form>
    </div>
</div>

@endsection