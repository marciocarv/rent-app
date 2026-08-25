<?php

namespace App\Http\Controllers;

use App\Models\ContractTemplate;
use Illuminate\Http\Request;

class ContractTemplateController extends Controller
{
    public function generateDefaults()
    {
        $templates = [
            [
                'name' => 'Contrato de Locação Residencial (Padrão)',
                'content' => '
                <h2 class="ql-align-center"><strong>CONTRATO DE LOCAÇÃO RESIDENCIAL</strong></h2>
                <p class="ql-align-center">(Lei nº 8.245/1991)</p>
                <p><br></p>
                <p>Pelo presente instrumento particular, as partes abaixo qualificadas:</p>
                <p><br></p>
                <p><strong>LOCADOR:</strong> [LOCADOR_NOME], [LOCADOR_NACIONALIDADE], [LOCADOR_MARITAL_STATUS], [LOCADOR_PROFESSION], portador do RG nº [LOCADOR_RG] e CPF nº [LOCADOR_CPF], residente e domiciliado em [LOCADOR_ADRESS].</p>
                <p><br></p>
                <p><strong>LOCATÁRIO:</strong> [LOCATARIO_NOME], [LOCATARIO_NACIONALIDADE], [LOCATARIO_MARITAL_STATUS], [LOCATARIO_PROFESSION], portador do RG nº [LOCATARIO_RG] e CPF nº [LOCATARIO_CPF], residente e domiciliado em [LOCATARIO_ADRESS].</p>
                <p><br></p>
                <p>Têm entre si justo e contratado o seguinte:</p>
                <p><br></p>
                <p><strong>CLÁUSULA 1ª – OBJETO E DESTINAÇÃO</strong></p>
                <p>O LOCADOR dá em locação ao LOCATÁRIO o imóvel situado em <strong>[IMOVEL_ENDERECO]</strong>, composto por <span style="color: red;">[descrição: número de quartos, banheiros, vagas, área aproximada etc.]</span>, destinado exclusivamente a fins residenciais (moradia do LOCATÁRIO e sua família). É vedada qualquer alteração de destinação ou uso comercial/profissional sem autorização prévia e escrita do LOCADOR.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 2ª – PRAZO</strong></p>
                <p>O prazo da locação é de 30 (trinta) meses, com início em <strong>[DATA_INICIO]</strong> e término em <strong>[DATA_FIM]</strong>.</p>
                <p>Findo o prazo, se o LOCATÁRIO permanecer no imóvel por mais de 30 dias sem oposição do LOCADOR, a locação prorrogar-se-á por prazo indeterminado, nas mesmas condições (art. 46 da Lei 8.245/91).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 3ª – ALUGUEL, PAGAMENTO E REAJUSTE</strong></p>
                <p>O aluguel mensal é de <strong>[VALOR_ALUGUEL]</strong>, a ser pago até o dia <strong>[DIA_VENCIMENTO]</strong> de cada mês, mediante [PAYMENT_METHOD] na conta indicada pelo LOCADOR.</p>
                <p>O valor será reajustado anualmente pelo índice <span style="color: red;">[IGP-M/FGV ou IPCA/IBGE]</span>, ou outro que o substitua.</span></p>
                <p>Em caso de atraso: multa de até 10% sobre o valor devido + juros de 1% ao mês + correção monetária.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 4ª – GARANTIA LOCATÍCIA</strong></p>
                <p>Como única garantia (art. 37 da Lei 8.245/91), o LOCATÁRIO oferece:</p>
                <p>[ ] Caução em dinheiro no valor de até 3 meses de aluguel (R$ [VALOR_ALUGUEL]), depositada em conta poupança;</p>
                <p>[ ] Fiador: [qualificação completa do fiador e cônjuge, se casado];</p>
                <p>[ ] Seguro-fiança (apólice nº [número]);</p>
                <p>[ ] Outra modalidade permitida.</p>
                <p>É vedada a cumulação de garantias.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 5ª – ENCARGOS</strong></p>
                <p>São de responsabilidade do LOCATÁRIO: consumo de água, energia elétrica, gás, condomínio ordinário e taxas de uso.</p>
                <p>São de responsabilidade do LOCADOR: IPTU (salvo disposição em contrário), despesas extraordinárias de condomínio e seguro do imóvel (salvo acordo diferente).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 6ª – OBRIGAÇÕES DAS PARTES</strong></p>
                <p>Do LOCADOR: entregar o imóvel em condições de uso, garantir o uso pacífico, responder por vícios anteriores e fornecer recibos discriminados.</p>
                <p>Do LOCATÁRIO: pagar pontualmente, usar o imóvel conforme destinação, zelar pela conservação, não sublocar sem autorização escrita, restituir o imóvel no estado em que o recebeu (salvo desgaste natural) e comunicar avarias.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 7ª – VISTORIA</strong></p>
                <p>Será realizada vistoria de entrada e de saída, com laudo fotográfico que integra este contrato.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 8ª – BENFEITORIAS E SUBLOCAÇÃO</strong></p>
                <p>Benfeitorias necessárias são indenizáveis; úteis e voluptuárias dependem de autorização prévia e escrita.</p>
                <p>É proibida a sublocação, cessão ou empréstimo sem autorização expressa do LOCADOR.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 9ª – RESCISÃO E MULTA</strong></p>
                <p>Rescisão antecipada pelo LOCATÁRIO: multa proporcional ao tempo restante (geralmente equivalente a 3 meses de aluguel, reduzida pro rata – art. 4º).</p>
                <p>Exceção: transferência de emprego para outra localidade (com aviso de 30 dias).</p>
                <p>Hipóteses de despejo seguem a Lei do Inquilinato.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 10ª – DIREITO DE PREFERÊNCIA</strong></p>
                <p>Em caso de venda do imóvel, o LOCATÁRIO tem preferência na aquisição (art. 27).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 11ª – FORO</strong></p>
                <p>Fica eleito o foro da comarca de [cidade/UF] para dirimir quaisquer controvérsias.</p>
                <p><br></p>
                <p>E, por estarem assim justos e contratados, firmam o presente em 2 (duas) vias de igual teor.</p>
                <p><br></p>
                <p><span style="color: red;">[Local]</span>, [DATE].</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p><strong>[LOCADOR_NOME]</strong> (Locador)</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p><strong>[LOCATARIO_NOME]</strong> (Locatário)</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p>FIADOR (se houver)</p>
                <p><br></p>
                <p>Testemunhas: _______________________________</p>
                                '
                            ],
                            [
                                'name' => 'Contrato de Locação Comercial',
                                'content' => '
                <h2 class="ql-align-center"><strong>CONTRATO DE LOCAÇÃO COMERCIAL</strong></h2>
                <p class="ql-align-center">(Lei nº 8.245/1991 – arts. 51 a 57)</p>
                <p><br></p>
                <p>Pelo presente instrumento particular, as partes abaixo qualificadas:</p>
                <p><br></p>
                <p><strong>LOCADOR:</strong> [LOCADOR_NOME], [LOCADOR_CPF], com sede em [LOCADOR_ADRESS].</p>
                <p><br></p>
                <p><strong>LOCATÁRIO:</strong> [LOCATARIO_NOME], [LOCATARIO_CPF], com sede em [LOCATARIO_ADRESS], neste ato representado por [LOCATARIO_NOME].</p>
                <p><br></p>
                <p>Têm entre si justo e contratado o seguinte:</p>
                <p><br></p>
                <p><strong>CLÁUSULA 1ª – OBJETO E DESTINAÇÃO</strong></p>
                <p>O LOCADOR dá em locação ao LOCATÁRIO o imóvel comercial situado em <strong>[IMOVEL_ENDERECO]</strong>, matriculado sob nº [número] no Cartório de Registro de Imóveis de [cidade/UF], composto por [descrição detalhada: área, salas, vagas etc.], destinado exclusivamente ao exercício da atividade comercial de [descrever o ramo: loja de roupas, escritório de advocacia, restaurante etc.].</p>
                <p>É vedada alteração de destinação ou uso residencial sem autorização prévia e escrita.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 2ª – PRAZO</strong></p>
                <p>O prazo da locação é de [36 / 60] meses, com início em <strong>[DATA_INICIO]</strong> e término em <strong>[DATA_FIM]</strong>.</p>
                <p>(Recomendado prazo que permita, somado a eventuais prorrogações, atingir 5 anos para fins de ação renovatória – art. 51).</p>
                <p>Findo o prazo sem manifestação, a locação poderá prorrogar-se por prazo indeterminado, podendo ser denunciada com aviso prévio de 30 dias.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 3ª – ALUGUEL, PAGAMENTO E REAJUSTE</strong></p>
                <p>O aluguel mensal é de <strong>[VALOR_ALUGUEL]</strong>, pago até o dia <strong>[DIA_VENCIMENTO]</strong> de cada mês, mediante [PIX / transferência / boleto].</p>
                <p>Reajuste anual pelo índice <span style="color: red;">[IGP-M/FGV ou IPCA/IBGE]</span>, ou outro que o substitua.</p>
                <p>Atraso: multa de até 10% + juros de 1% ao mês + correção monetária.</p>
                <p>É possível revisão judicial do valor após 3 anos (art. 19).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 4ª – GARANTIA LOCATÍCIA</strong></p>
                <p>Como única garantia (art. 37), o LOCATÁRIO oferece:</p>
                <p>[ ] Caução de até 3 meses de aluguel;</p>
                <p>[ ] Fiador com renúncia ao benefício de ordem;</p>
                <p>[ ] Seguro-fiança;</p>
                <p>[ ] Outra modalidade permitida.</p>
                <p>Proibida a cumulação.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 5ª – ENCARGOS</strong></p>
                <p>São de responsabilidade do LOCATÁRIO: IPTU, condomínio (ordinário e, se acordado, extraordinário), água, energia, gás, seguro contra incêndio e demais taxas decorrentes do uso comercial.</p>
                <p>Despesas extraordinárias de condomínio podem ser do LOCADOR, salvo disposição em contrário.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 6ª – OBRIGAÇÕES DAS PARTES</strong></p>
                <p>Do LOCADOR: entregar o imóvel em condições adequadas ao uso comercial, garantir o uso pacífico e responder por vícios anteriores.</p>
                <p>Do LOCATÁRIO: pagar pontualmente, usar o imóvel conforme o ramo autorizado, obter e manter alvarás e licenças necessárias, zelar pela conservação, não sublocar/ceder sem autorização escrita e restituir o imóvel no estado em que o recebeu (salvo desgaste normal).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 7ª – VISTORIA E BENFEITORIAS</strong></p>
                <p>Vistoria de entrada e saída com laudo fotográfico.</p>
                <p>Benfeitorias necessárias são indenizáveis; úteis e voluptuárias dependem de autorização prévia. Em contratos comerciais é comum cláusula de renúncia à indenização por benfeitorias (válida segundo jurisprudência).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 8ª – RENOVAÇÃO (AÇÃO RENOVATÓRIA)</strong></p>
                <p>O LOCATÁRIO poderá exercer o direito à renovação compulsória se preencher os requisitos do art. 51 da Lei 8.245/91 (contrato escrito por prazo determinado, mínimo de 5 anos de locação e exploração do mesmo ramo por pelo menos 3 anos).</p>
                <p><br></p>
                <p><strong>CLÁUSULA 9ª – RESCISÃO E MULTA</strong></p>
                <p>Rescisão antecipada pelo LOCATÁRIO: multa proporcional ao tempo restante (art. 4º).</p>
                <p>Hipóteses de despejo e retomada seguem os arts. 9º, 52 e seguintes da Lei do Inquilinato.</p>
                <p><br></p>
                <p><strong>CLÁUSULA 10ª – FORO</strong></p>
                <p>Fica eleito o foro da comarca de <span style="color: red;">[cidade/UF]</span>.</p>
                <p><br></p>
                <p>E, por estarem assim justos e contratados, firmam o presente em 2 (duas) vias.</p>
                <p><br></p>
                <p><span style="color: red;">[Local]</span>, [DATE].</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p><strong>[LOCADOR_NOME]</strong> (Locador)</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p><strong>[LOCATARIO_NOME]</strong> (Locatário)</p>
                <p><br></p>
                <p>____________________________________________________</p>
                <p>FIADOR / REPRESENTANTE (se houver)</p>
                <p><br></p>
                <p>Testemunhas: _______________________________</p>
                                '
            ],
            [
                'name' => 'Termo de Entrega de Chaves',
                'content' => '<h2 class="ql-align-center">TERMO DE RECEBIMENTO E ENTREGA DE CHAVES</h2><p><br></p><p>Eu, <strong>[LOCATARIO_NOME]</strong>, declaro para os devidos fins que recebi de <strong>[LOCADOR_NOME]</strong> as chaves referentes ao imóvel situado em <strong>[IMOVEL_ENDERECO]</strong>, na data de <strong>[DATA_INICIO]</strong>.</p><p><br></p><p>Declaro ainda que o imóvel encontra-se em perfeitas condições de uso e habitabilidade.</p><p><br></p><p>____________________________________________________</p><p><strong>[LOCATARIO_NOME]</strong> (Locatário)</p>'
            ]
        ];

        foreach ($templates as $temp) {
            ContractTemplate::firstOrCreate([
                'landlord_id' => auth()->id(),
                'name' => $temp['name']
            ], [
                'content' => $temp['content']
            ]);
        }

        return redirect()->back()->with('success', 'Modelos profissionais gerados com sucesso!');
    }

    public function index()
    {
        $templates = ContractTemplate::where('landlord_id', auth()->id())->get();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        ContractTemplate::create([
            'landlord_id' => auth()->id(),
            'name' => $request->name,
            'content' => $request->content,
        ]);

        return redirect()->route('templates.index')->with('success', 'Modelo criado com sucesso!');
    }

    public function edit(ContractTemplate $template)
    {
        if ($template->landlord_id !== auth()->id()) abort(403);
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, ContractTemplate $template)
    {
        if ($template->landlord_id !== auth()->id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template->update([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        return redirect()->route('templates.index')->with('success', 'Modelo atualizado com sucesso!');
    }

    public function destroy(ContractTemplate $template)
    {
        if ($template->landlord_id !== auth()->id()) abort(403);
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Modelo excluído com sucesso!');
    }
}
