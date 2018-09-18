<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $resquest) {
        $address = $this->readFile('trace');
        $tamanhoCache = $resquest->cache;
        $tamanhoBloco = $resquest->tamanhoBloco;
        $mapeamento = $resquest->mapeamento;
        $substituicao = $resquest->substituicao;
        $params['linhas_arquivo'] = 0;
        $params['linhas_leituras_arquivo'] = 0;
        $params['linhas_escritas_arquivo'] = 0;
        foreach ($tamanhoCache as $key => $value) {
            foreach ($mapeamento as $valueMap) {
                foreach ($substituicao as $valueSub) {
                    $numeroLinhas = $value / $tamanhoBloco;
                    $quantidadeConjuntos = $numeroLinhas / $valueMap;
                    $tamanho_conjunto = $this->calcularParteEndereco($quantidadeConjuntos);
                    $tamanho_palavra = $this->calcularParteEndereco($tamanhoBloco);
                    $tamanho_rotulo = 32 - ($tamanho_palavra + $tamanho_conjunto);
                    $memoriaPrincipal = new MemoriaPrincipal();
                    $memoriaCache = new MemoriaCache($quantidadeConjuntos, $valueMap);

                    $resultados = [
                        'leituras' => 0,
                        'escritas' => 0,
                        'total_operacoes' => 0,
                        'cache_leituras' => 0,
                        'cache_leituras_acertos' => 0,
                        'cache_leituras_acertos_taxa' => 0,
                        'cache_escritas' => 0,
                        'cache_escritas_acertos' => 0,
                        'cache_escritas_acertos_taxa' => 0,
                        'cache_total_operacoes' => 0,
                        'cache_taxa_acerto_total' => 0,
                        'memoria_principal_leituras' => 0,
                        'memoria_principal_leituras_acertos' => 0,
                        'memoria_principal_escritas' => 0,
                        'memoria_principal_escritas_acertos' => 0,
                        'memoria_principal_total_operacoes' => 0,
                        'tempo_medio' => 0
                    ];

                    foreach ($address as $key => $options) {
                        $endereco = $options['address'];
                        $endereco = str_pad($endereco, 32, "0", STR_PAD_LEFT);
                        $endereco_rotulo = substr($endereco, 0, $tamanho_rotulo);

                        $endereco_conjunto = substr($endereco, $tamanho_rotulo + 1, $tamanho_conjunto);
                        $conjunto = $memoriaCache->procuraConjunto($endereco_conjunto);
                        if (!is_null($conjunto)) {
                            //Procura o rotulo das linhas do conjunto
                            $conjunto_rotulo = $conjunto->procuraRotulo($endereco_rotulo);

                            //Se rótulo existe
                            if ($conjunto_rotulo == true) {
                                //Soma um no acertos de leitura da cache
                                $resultados['cache_leituras_acertos'] ++;
                            } else {
                                $encontrou_mp = $memoriaPrincipal->search($endereco);
                                //Soma um na leitura da memória principal
                                $resultados['memoria_principal_leituras'] ++;

                                if ($encontrou_mp == true) {
                                    $resultados['memoria_principal_leituras_acertos'] ++;
                                } else {
                                    $memoriaPrincipal->add($endereco);
                                }

                                //Se rótulo não existe grava
                                $conjunto->gravaRotulo($endereco_rotulo, $valueSub, 0, $memoriaPrincipal, $endereco);
                            }
                        } else {
                            //procura na memória principal
                            $encontrou_mp = $memoriaPrincipal->search($endereco);

                            $resultados['memoria_principal_leituras'] ++;

                            if ($encontrou_mp == true) {
                                $resultados['memoria_principal_leituras_acertos'] ++;
                            } else {
                                $memoriaPrincipal->add($endereco);
                            }

                            //Se conjunto não existe grava na cache
                            $conjunto = $memoriaCache->gravaConjunto($endereco_conjunto);

                            //salva rotulo no conjunto
                            $conjunto->gravaRotulo($endereco_rotulo, $valueSub, 0, $memoriaPrincipal, $endereco);
                        }
                    }
//                    if ($valueSub == 0) {
//                        
//                    } else {
//                        
//                    }
//                    echo $value . '-' . $valueMap . '-' . $valueSub . ' - ' . $tamanhoBloco . '<br/>';
                }
            }
        }

        $resultados['total_operacoes'] = $resultados['leituras'] + $resultados['escritas'];

//        $resultados['cache_leituras_acertos_taxa'] = number_format(($resultados['cache_leituras_acertos'] * 100) / $resultados['cache_leituras'], 4, '.', '');

        //Operações de escrita na cache
//        $resultados['cache_escritas_acertos_taxa'] = number_format(($resultados['cache_escritas_acertos'] * 100) / $resultados['cache_escritas'], 4, '.', '');

        $resultados['total_operacoes_cache'] = $resultados['cache_leituras'] + $resultados['cache_escritas'];

//        $cache_taxa_acerto_total = (($resultados['cache_leituras_acertos'] + $resultados['cache_escritas_acertos']) * 100) / $resultados['total_operacoes_cache'];

//        $resultados['cache_taxa_acerto_total'] = number_format($cache_taxa_acerto_total, 4, '.', '');

        $resultados['total_operacoes_memoria_principal'] = $resultados['memoria_principal_leituras'] + $resultados['memoria_principal_escritas'];



        return response()->json($resultados);
    }

    public function readFile($file) {
        $buffer = fopen($file, "r") or die("Erro ao tentar abrir arquivo!");
        $address = [];

        while (!feof($buffer)) {
            $line = fgets($buffer);

            if (strlen($line) > 0) {
                $options['address'] = $this->convertHexadecimalToBinary(substr($line, 0, 8));
                array_push($address, $options);
            }
        }
        fclose($buffer);

        return $address;
    }

    public function convertHexadecimalToBinary($hexadecimal) {
        $decimal = hexdec($hexadecimal);
        $binary = $this->convertDecimalToBinary($decimal);

        return $binary;
    }

    public function convertDecimalToBinary($decimal) {
        return decbin($decimal);
    }

    public function calcularParteEndereco($int) {
        $tamanho = 0;
        while ($int != 1) {
            $int = $int / 2;
            $tamanho++;
        }

        return $tamanho;
    }

}
