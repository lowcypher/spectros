
# Spectros Web  
Sistema de Análise de Valores com Tolerância

---

## 📌 Descrição

**Spectros Web** é uma aplicação web desenvolvida em PHP para análise automatizada de valores numéricos contidos em arquivos `.txt` compactados em `.zip`, aplicando um critério matemático de tolerância em relação a valores de referência definidos pelo usuário.

A ferramenta foi projetada para aplicações científicas, laboratoriais e experimentais que demandem validação rápida e sistemática de grandes conjuntos de dados estruturados em arquivos texto.

---

## 🎯 Objetivo

Permitir que pesquisadores:

- Insiram múltiplos valores de referência
- Definam uma tolerância numérica (±)
- Enviem um arquivo `.zip` contendo arquivos `.txt`
- Classifiquem automaticamente os valores como:
  - ✅ Dentro da Tolerância
  - ❌ Fora da Tolerância
- Exportem os resultados para:
  - 📄 PDF
  - 📊 Excel (.xlsx)

---

## 🔬 Fundamentação Matemática

Seja:

- R = {r1, r2, ..., rn} o conjunto de valores de referência  
- t ≥ 0 a tolerância definida  
- v o valor extraído do arquivo  

Define-se que um valor está **dentro da tolerância** se:

∃ r_i ∈ R tal que |v - r_i| ≤ t

Caso contrário, o valor é classificado como **fora da tolerância**.

---

## 🏗 Arquitetura

```
Spectros Web
│
├── index.php          # Interface de entrada
├── processa.php       # Extração e análise
├── export_pdf.php     # Exportação PDF (mPDF)
├── export_xlsx.php    # Exportação XLSX (PhpSpreadsheet)
├── footer.php
├── uploads/           # Diretório temporário
└── vendor/            # Dependências Composer
```

---

## ⚙️ Requisitos

- PHP 8.0 ou superior
- Extensão `zip` habilitada
- Composer instalado
- Servidor Apache ou Nginx
- Permissão de escrita no diretório `uploads/`

---

## 📦 Instalação

### 1️⃣ Clone o repositório

```bash
git clone https://github.com/lowcypher/spectros.git
cd spectros-web
```

### 2️⃣ Instale as dependências

```bash
composer install
```

### 3️⃣ Configure permissões

```bash
chmod -R 755 uploads ou chmod -R 777
```

### 4️⃣ Acesse via navegador

http://localhost/spectros-web/

---

## 📊 Funcionalidades

- Extração automática de arquivos `.zip`
- Processamento recursivo de arquivos `.txt`
- Leitura linha a linha
- Análise do primeiro valor numérico da linha
- Tabela interativa com DataTables
- Filtro dinâmico
- Exportação baseada no filtro aplicado

---

## 🔐 Segurança

Recomenda-se:

- Limitação de tamanho de upload no `php.ini`
- Implementação de validação contra Zip Slip
- Rotina periódica de limpeza do diretório `uploads/`
- Limitação de volume de arquivos processados

---

## 📜 Licença

Este software é distribuído sob a:

### GNU Affero General Public License v3 (AGPLv3)

Isso significa que:

- É livre para uso, estudo e modificação
- Obras derivadas devem manter a mesma licença
- O código-fonte deve ser disponibilizado mesmo se utilizado como serviço web (SaaS)

Licença completa:

https://www.gnu.org/licenses/agpl-3.0.html

---

## 📚 Como Citar

Se você utilizar esta ferramenta em pesquisa científica, por favor cite como:

### Formato ABNT

MEDEIROS, Mario. *Spectros Web – Sistema de Análise de Valores com Tolerância*. Software. 2026. Licenciado sob GNU AGPLv3.

### BibTeX

```bibtex
@software{medeiros2026spectros,
  author  = {Mario Medeiros},
  title   = {Spectros Web – Sistema de Análise de Valores com Tolerância},
  year    = {2026},
  license = {GNU Affero General Public License v3},
  url     = {https://github.com/lowcypher/spectros}
}
```

---

## 🤝 Contribuições

Contribuições são bem-vindas.

Ao submeter código:

- O autor concorda que o código será distribuído sob AGPLv3
- Deve manter avisos de copyright
- Deve documentar alterações relevantes

### Sugestões de melhoria

- Validação segura de extração ZIP
- Estatísticas agregadas
- Parametrização de coluna analisada
- Persistência em banco de dados
- API REST para integração

---

## 🧪 Aplicações Científicas Potenciais

- Validação espectrométrica
- Controle de qualidade laboratorial
- Processamento de dados experimentais
- Análise de tolerância em medições físicas
- Processamento automatizado de laudos técnicos

---

## ⚠️ Aviso Legal

Este software é fornecido **sem garantia de qualquer tipo**.

O autor não se responsabiliza por uso incorreto, interpretação inadequada de dados ou aplicações fora do contexto científico adequado.

---

## 👨‍🔬 Autor

Mario Medeiros  
Projeto Científico Independente  
2026  

---

## 🌍 Filosofia do Projeto

Este projeto segue os princípios de ciência aberta, reprodutibilidade e acesso universal ao conhecimento.

O objetivo é permitir que pesquisadores utilizem, estudem e ampliem a ferramenta sem restrições proprietárias.
