---

# Laravel Space Converter API

Este projeto é uma API simples desenvolvida com Laravel para realizar a conversão de **quilômetros (KM)** para **anos-luz** e vice-versa.

## 🛠️ Funcionalidades
- **Conversão de Medidas Espaciais**:
  - Quilômetros para Anos-Luz.
  - Anos-Luz para Quilômetros.
- **Validação de Entrada**:
  - Garante que apenas números positivos sejam aceitos.
- **Retorno de Erros Bem-Formatados**:
  - Mensagens detalhadas para entradas inválidas.
- **Testes Automatizados**:
  - Testes de conversão e validação de entrada.

---

## 🖥️ Tecnologias Utilizadas
- **Laravel 10.x**
- **PHP 8.2**
- **Composer**
- **PHPUnit**

---

## 🚀 Como Rodar o Projeto

### Pré-requisitos
- PHP 8.2 ou superior.
- Composer instalado.
- Servidor web (como Apache ou Nginx).

### Passo 1: Clonar o Repositório
```bash
git clone https://github.com/carloosf/km-lightyears.git
cd km-lightyears
```

### Passo 2: Configurar o Arquivo `.env`
Copie o arquivo `.env.example` para `.env`. Mesmo que não use banco de dados, o Laravel exige este arquivo para configurar outras variáveis como o `APP_KEY`:
```bash
cp .env.example .env
```

### Passo 3: Instalar Dependências
```bash
composer install
```

### Passo 4: Gerar a Chave da Aplicação
```bash
php artisan key:generate
```

### Passo 5: Subir o Servidor Local
```bash
php artisan serve
```

Por padrão, o projeto estará acessível em [http://localhost:8000](http://localhost:8000).

---

## 🧪 Testando a API

### Endpoints Disponíveis

#### 1. Quilômetros para Anos-Luz
**POST** `/api/quilometros`

**Exemplo de Corpo da Requisição**:
```json
{
  "quilometros": 9460730472580.8
}
```

**Exemplo de Resposta**:
```json
{
  "anosLuz": 1
}
```

---

#### 2. Anos-Luz para Quilômetros
**POST** `/api/anosLuz`

**Exemplo de Corpo da Requisição**:
```json
{
  "anosLuz": 1
}
```

**Exemplo de Resposta**:
```json
{
  "quilometros": 9460730472580.8
}
```

---

### Executando Testes

#### Criando Testes
Os testes para o projeto estão localizados em `tests/Feature/ConversionTest.php`. Eles cobrem os seguintes casos:
1. Conversão de quilômetros para anos-luz.
2. Conversão de anos-luz para quilômetros.
3. Validação de entradas inválidas.

#### Exemplo de Teste em `ConversionTest.php`:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConversionTest extends TestCase
{

    public function test_convert_kilometers_to_light_years()
    {
        $response = $this->postJson('/api/quilometros', [
            'quilometros' => 9460730472580.8
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'anosLuz' => 1
                 ]);
    }

    public function test_convert_light_years_to_kilometers()
    {
        $response = $this->postJson('/api/anosLuz', [
            'anosLuz' => 1
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'quilometros' => 9460730472580.8
                 ]);
    }

    public function test_invalid_kilometers_input()
    {
        $response = $this->postJson('/api/quilometros', [
            'quilometros' => -100
        ]);

        $response->assertStatus(400);
    }

    public function test_invalid_light_years_input()
    {
        $response = $this->postJson('/api/anosLuz', [
            'anosLuz' => -1
        ]);

        $response->assertStatus(400);
    }
}
```

#### Executando os Testes
Para executar todos os testes:
```bash
php artisan test
```

Para executar um teste específico:
```bash
php artisan test --filter test_convert_kilometers_to_light_years
```

---

## 🤝 Contato

Para dúvidas, sugestões ou colaborações, entre em contato:

- **Nome**: Carlos Silva
- **E-mail**: contato.carlossilva@gmail.com
- **LinkedIn**: [linkedin.com/in/carloosf](https://linkedin.com/in/carloosf)
