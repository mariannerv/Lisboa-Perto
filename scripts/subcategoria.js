document.getElementById("categoria").addEventListener("change", function() {
    var categoria = this.value;
    var subCategoriaDropdown = document.getElementById("subCategoria");
    subCategoriaDropdown.innerHTML = "<option value=''>Select Subcategoria</option>";
    
    if (categoria === "Saneamento") {
        var saneamentoOptions = [
            "Entupimento de sarjeta ou sumidouro",
            "Fuga de água potável em espaço publico",
            "Grelha de sumidouro danificada ou em falta",
            "Inundação em espaço publico ou esgoto na via",
            "Limpeza mecânica de caixa de esgoto",
            "Obstrução de coletor/ramal de esgoto",
            "Sarjeta danificada",
            "Tampa de esgoto danificada ou desnivelada"
        ];
        saneamentoOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Passeios e Acessibilidades") {
        var passeiosOptions = [
            "Abatimentos superficiais",
            "Abrigos concessionados de paragens de transportes públicos - Manutenção",
            "Acesso para cidadãos com mobilidade reduzida",
            "Buraco no passeio",
            "Calçada artística - Manutenção",
            "Caleira danificada em passeios",
            "Colocação de novo mobiliário urbano",
            "Colocação de novos pilares",
            "Concessionárias - Danos e Obras",
            "Corrimãos, guardas ou gradeamentos - Manutenção",
            "Descalcetamento de passeio",
            "Lancil danificado ou em falta",
            "Marcos e bocas de incêndio (Fuga de água)", 
            "Mesas, bancos ou outro mobiliário urbano - Manutenção",
            "Pilares - Manutenção",
            "Placa toponímica danificada ou em falta"

        ];
            passeiosOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Higiene Urbana") {
        var higieneOptions = [
            "Contentor coletivo (4 rodas) fora do local",
            "Contentores de resíduo danificados",
            "Contentoras na via pública",
            "Corte de ervas em passeios",
            "Entulhos, objetos volumosos, resíduos de jardim ou perigosos abandonados na via pública",
            "Grafitis",
            "Limpeza de dejetos caninos",
            "Outras situações de sacos, pilhões, fitas ou papeleiras",
            "Pedido de contentor de média capacidade (4 rodas)",
            "Pedido de instalação de ecoponto ou vidrão",
            "Pedido de pilhão",
            "Pragas e doenças",
            "Sacos ou outros lixos abandonados",
            "Substituição ou reparação de ecoponto, vidrão ou ecoilha danificados"
        ];

            higieneOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Iluminacao Publica") {
        var IlumiOptions = [
            "Arruamento às escuras",
            "Arruamento com luz insuficiente",
            "Candeeiro apagado",
            "Candeeiro com luz intermitente",
            "Candeeiro danificado (caído, partido, cabos elétricos à vista, falta de portinhola, etc)",
            "Monumento - Manutenção em iluminação",
            "Outras situações"
        ];

            IlumiOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Estradas e Ciclovias") {
        var ECOptions = [
            "Abatimentos superficiais",
            "Buraco na faixa de rodagem",
            "Ciclovia - Manutenção",
            "Concessionárias - Danos e obras",
            "Estacionamento de motas - Manutenção",
            "Estacionamento de motas - Novo, remoção, reposicionamento",
            "Estacionamento de velocípedes - Manutenção",
            "Estacionamento de velocípedes - Novo ou remoção",
            "Semáforos - Manutenção",
            "Semáforos - Novos",
            "Sinalização - Manutenção",
            "Sinalização - Nova"
        ];

            ECOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Arvores e espacos verdes") {
        var verdesOptions = [
            "Árvores - Plantação",
            "Árvores, arbustos ou relva - Manutenção", 
            "Bebedouros, chafarizes, fontanário ou lago - Manutenção",
            "Cercas, vedações e outras estruturas - Manutenção",
            "Colocação de novo mobiliário urbano",
            "Hortas urbanas - Manutenção",
            "Mesas, bancos ou outro mobiliário urbano - Manutenção",
            "Parques Infantis e Juvenis - Manutenção",
            "Redes de rega - Manutenção"
        ];

            verdesOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Equipamentos Municipais - Desporto") {
        var desportoOptions = [
            "Manutenção e/ou reparação",
            "Equipamentos de Desporto - Novos"
        ];

            desportoOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Seguranca publica e ruido") {
        var SROptions = [
            "Animais potencialmente perigosos",
            "Edíficio, muro, escarpa ou talude degradado",
            "Estacionamento abusivo",
            "Fiscalização ambiental",
            "Fiscalização de alojamento locais (turísticos)",
            "Fiscalização de trânsito",
            "Fiscalização de venda ambulante",
            "Insegurança na via pública",
            "Obras ilegais - Edificado, via pública e ruído",
            "Ocupação ilegal de via pública",
            "Ruído de vizinhança e na via pública",
            "Viaturas abandonadas"
        ];

            SROptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Habitacao municipal") {
        var HMOptions = [
            "Emparedamento ou entaipamento",
            "Gebalis - Manutenção ou reparação",
            "Infiltração",
            "Manutenção ou reparação",
            "Reparação de instalação elétrica na zona de serviços comuns",
            "Reparação ou mudança de fechadura e caixas de correio",
            "Rotura e/ou desentupimento"
        ];

            HMOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Animais em ambiente urbano") {
        var animaisOptions = [
            "Recolha de animais de pequeno e médio porte mortos ou acidentados, na via pública",
            "Recolha de animais de pequeno e médio porte mortos ou adoentados em propriedade privada",
            "Recolha de animais de pequeno e médio porte vivos em via pública"
        ];

            animaisOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Equipamentos Municipais - cultura") {
        var culturaOptions = [
            "Escultura - Manutenção",
            "Cabine de leitura - Manutenção",
            "Cabine de leitura - Nova"
        ];

            culturaOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    } else if (categoria === "Equipamentos municipais - educacao") {
        var eduOptions = [
            "Manutenção e/ou reparação"
        ];

            eduOptions.forEach(function(option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.textContent = option;
            subCategoriaDropdown.appendChild(optionElement);
        });
    }
});