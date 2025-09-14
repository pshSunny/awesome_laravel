# Coding Style Guide (Code Convention)

본 문서는 Laravel 프로젝트에서 사용하는 **코드 컨벤션**을 정의합니다.  
팀원은 모든 코드 작성 시 이 규칙을 따라야 하며, PR 생성 전 반드시 코드 스타일 검증을 수행해야 합니다.

---

## 1. PHP

### 1-1. **PSR-12** 표준 준수
- PSR(PHP Standard Recommendation) 공식 문서:
  - [PSR-12: Extended Coding Style Guide](https://www.php-fig.org/psr/psr-12/)
  - [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)

### 1-2. Coding Style
- 들여쓰기: **4 spaces**
  - .editorconfig (IDE에서 내부 설정보다 .editorconfig을 우선 적용)
    ```
    # .editorconfig
    .....
    [*]
    .....
    indent_size = 4
    indent_style = space
    ```
  - IntelliJ IDEA → Settings → Editor → Code Style → PHP → Tabs and Indents
    - Tab size: 4
    - Indent: 4
    - Continuation indent: 4 (줄이 길 때 자동 들여쓰기)
- 한 줄 최대 길이: **120자** 권장
  - PSR-12: 120자 권장 (최대 120, 80은 soft limit)
  - Laravel Pint도 기본 120에 맞춰져 있음
  - IntelliJ IDEA → Settings → Editor → Code Style → PHP → Wrapping and Braces
    - Hard wrap at: 120
    - Wrap on typing: Yes (120 넘으면 자동 줄 개행)
- 중괄호 스타일: K&R 스타일 (함수, 조건문, 반복문 등)
  - 여는 중괄호 {}: 제어문(조건문, 반복문) 같은 키워드와 같은 줄에 배치
  - 닫는 중괄호 }: 새로운 줄에 배치, 블록 시작 위치와 같은 들여쓰기 레벨
- 클래스, 메서드, 함수 중괄호는 **다음 줄**에 배치
- `declare(strict_types=1);`는 파일 첫 번째 문 뒤에 위치 👀❓
- 네임스페이스 선언 후, `use` 블록 전후에는 빈 줄 추가
- 모든 메서드에는 visibility(`public`, `protected`, `private`)를 명시
- **클래스 네이밍**: `PascalCase` (예: `UserService`, `OrderController`)
- **메서드/변수 네이밍**: `camelCase` (예: `findUserById()`, `totalAmount`)
- **예외 처리**:
  - 반드시 `try/catch` 사용
  - 사용자 에러 메시지와 시스템 로그 분리: 
    - 사용자에게는 일반화된 에러 메시지를 보여주고, 상세 오류는 로그로 기록
  - `throw new \Exception()` 대신 의미 있는 커스텀 예외 클래스를 사용하는 것을 권장

```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Exceptions\UserNotFoundException;

class UserService
{
    public function findUserById(int $id): User
    {
        try {
            $user = User::find($id);

            if (!$user) {
                throw new UserNotFoundException("User with ID {$id} not found");
            }

            return $user;
        } catch (UserNotFoundException $e) {
            // 예외 상황: 사용자 없음 → 로깅 후 상위 호출자에 전달
            logger()->warning($e->getMessage());
            throw $e;
        } catch (\Throwable $e) {
            // 알 수 없는 오류: 로그 남기고 일반 예외로 처리
            logger()->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
           throw new \RuntimeException("사용자 조회 중 문제가 발생했습니다.");
        }
    }
}
```

### 1-3. PHP 프레임워크
- Laravel 12

### 1-4. 자동화 도구
| 도구              | 역할 | 특징 | Laravel 적합성 |
|-------------------|------|------|----------------|
| **PHPCS** (php_codesniffer) | 검사기 (Linter) | - PSR-12 등 코딩 표준 위반 여부 검사<br>- IDE/CI 연동 쉬움<br>- 자동 수정은 제한적 | ✅ 검사 용도로 적합 |
| **PHP-CS-Fixer**  | 수정기 (Fixer)  | - PSR-12/Symfony 스타일 자동 수정<br>- 규칙 커스터마이징 가능<br>- 범용 PHP 프로젝트에 적합 | ⚪ 일반 PHP 프로젝트에 적합 |
| **Laravel Pint**  | 수정기 (Fixer)  | - PHP-CS-Fixer 기반<br>- Laravel 공식 제공<br>- PSR-12 + Laravel 스타일 자동화<br>- 설정 단순 (`pint.json`) | ✅ Laravel에 최적화 |

  - 로컬 개발자
    - **PHPCS** (실시간 경고 확인)
      - 코드 작성 중 실시간으로 PSR-12 위반 경고 확인
      - IntelliJ IDEA / PhpStorm / VSCode 등 IDE에 연동
      - **역할**: "틀린 곳을 알려줌"
      - 의존성 설치 & 사용
        ```shell
        $ composer require --dev squizlabs/php_codesniffer # vendor/bin/phpcs 실행 파일 생성됨
        $ vendor/bin/phpcs --standard=PSR12 app/
        ```
      - IntelliJ IDEA에 PHPCS 연동
        - Settings → Languages & Frameworks → PHP → Quality Tools → PHP_CodeSniffer
          - Configuration: System PHP (Path to phpcs: ./vendor/bin/phpcs)
          - Check files with extensions: `php,inc` (`js,css` 제외)
          - Coding standard → PSR12 선택
        - Settings → Editor → Inspections → Quality tools
          - "PHP_CodeSniffer validation" 활성화
      - 단, PHPCS와 Pint는 일부 충돌 발생하므로 비사용 권장
        - 충돌 예)
          - PHPCS: `Closing brace must be on a line by itself`
          - Pint: `Laravel Pint: single_line_empty_body, phpdoc_align`
        - Pint가 라라벨 프로젝트 표준
        - 라라벨 프로젝트는 Pint 단독 사용 + IDE 설정 Pint 스타일로 통일이 안정적.
    - **Laravel Pint** (자동 포맷팅)
      - 저장하거나 커밋 전에 코드 스타일 자동 정리
      - **역할**: "틀린 걸 자동으로 고쳐줌"
      - 의존성 설치 & 사용
        ```shell
        $ composer require --dev laravel/pint # vendor/bin/pint 실행 파일 생성됨
        $ ./vendor/bin/pint
        ```
      - IntelliJ IDEA에 Pint 연동
        - Settings → Languages & Frameworks → PHP → Quality Tools → Laravel Pint
          - Configuration: System PHP (Path to phpcs: ./vendor/bin/pint)
          - Ruleset → laravel 선택
        - Settings → Editor → Inspections → Quality tools
          - "Laravel Pint validation" 활성화
        - 단, IDEA는 validation만 켜도 검사만 가능, 실제 포맷팅은 별도 External Tool/File Watcher 또는 CLI 실행이 필요
      - IntelliJ IDEA를 Pint 기준에 맞춰 설정
        - 빈 메소드의 중괄호 {} 를 같은 라인에 붙이도록 포맷팅
          - Settings → Editor → Code Style → PHP → Wrapping and Braces → Braces placement → Place braces for empty functions/methods on one line : 체크
        - PHPDoc @param 타입·변수명·설명 사이 2 spaces 포맷팅
          - Settings → Editor → Code Style → PHP → PHPDoc → PHPDoc '@param' spaces
          - Between tag and type / Between type and name / Between name and description: 각 2 spaces
        - ! 연산자 뒤에 반드시 공백(`!$value` → `! $value`) 포맷팅 (not_operator_with_successor_space)
          - Settings → Editor → Code Style → PHP → Spaces → Other → After unary Not(!): 체크
      - IntelliJ IDEA > Problem Description Sample
        ```
        phpcs: Visibility must be declared on method "test"
        Laravel Pint: visibility_required
        ```
    - Laravel Idea Plugin
      - php artisan 명령 지원 플러그인 
      - @todo 내용 보완하기 
  - CI/CD 👀❓ ⇒ 도입여부 검토 필요
    - **PHPCS + Pint (--test 모드) 함께 사용**
      - PHPCS: 위반 여부 리포트 (세밀한 검사 로그 제공)
      - Pint (--test): 코드가 규칙에 맞는지 확인 (자동 수정은 안 함)
      - **역할**: 최종 코드 품질 보장
- 컨트롤러: RESTful 컨벤션 준수 (`index`, `store`, `update`, `destroy`)

---

## 2. HTML / Blade

### 2-1. Coding Style
- 들여쓰기: **2 spaces**
  - 중첩이 깊어질 수 있어 4 spaces보다 2 spaces가 일반적
- 한 줄 길이: **120자** 권장
  - IntelliJ IDEA → Settings → Editor → Code Style → Other
    - Hard wrap at: 120
    - Wrap on typing: Yes (120 넘으면 자동 줄 개행)

---

## 3. JavaScript

### 3-1. **ES6+** 표준 준수
- ES6(ECMAScript 2015 또는 ECMAScript 6) 공식 문서:
  - [ECMAScript® 2015 Language Specification: ECMA-262 6th Edition](https://262.ecma-international.org/6.0/)
  - [Javascript 2015 (ES6)](https://www.w3schools.com/js/js_es6.asp)

### 3-2. Coding Style
- 들여쓰기: **2 spaces**
  - Airbnb Style Guide, Google Style Guide, ESLint 기본 → 2 spaces
  - 가독성 + 코드량이 많아져도 관리 용이
  - .editorconfig (IDE에서 내부 설정보다 .editorconfig을 우선 적용)
    ```
    # .editorconfig
    .....
    [*.{js,ts,jsx,tsx,css}]
    indent_style = space
    indent_size = 2
    ```
  - IntelliJ IDEA → Settings → Editor → Code Style → JavaScript
    - Tab size: 2
    - Indent: 2
    - Continuation indent: 2 (줄이 길 때 자동 들여쓰기)
- 한 줄 길이: **120자** 권장
  - IntelliJ IDEA → Settings → Editor → Code Style → JavaScript → Wrapping and Braces
    - Hard wrap at: 120
    - Wrap on typing: Yes (120 넘으면 자동 줄 개행)
- 중괄호 스타일: K&R 스타일 (함수, 조건문, 반복문 등)
  - 여는 중괄호 {}: 제어문(조건문, 반복문) 같은 키워드와 같은 줄에 배치
  - 닫는 중괄호 }: 새로운 줄에 배치, 블록 시작 위치와 같은 들여쓰기 레벨
- 변수 선언
  - `const`/`let`만 사용 (`var` 금지)
  - `const`는 재할당이 없는 경우, `let`은 값이 변경될 가능성이 있는 경우 사용
  ```javascript
  const MAX_USERS = 10;
  let count = 0;
  ```
- 네이밍 규칙
  - 함수/변수: `camelCase`
  - 클래스 / 생성자 함수: `PascalCase`
  - 상수 / 환경 변수: `UPPER_SNAKE_CASE`
  - 객체 속성: `camelCase`
    ```javascript
    const user = { firstName: 'Alice', lastName: 'Kim' };
    ```
- 따옴표: 단일(') 권장
- **옵셔널 체이닝 연산자(?)**와 **Null 병합 연산자(??)** 사용: 안전한 값 접근을 위함.
- **템플릿 리터럴 문자열** 사용: 문자열 연결보다 가독성이 좋은 문법.
  ```javascript
  // ✅ Good
  const message = `Hello, ${userName}!`;
    
  // ❌ Bad
  const message = "Hello, " + userName + "!";
  ```
- 함수형 프로그래밍 지향
  - 화살표 함수 사용 (특히 콜백/익명 함수)
    ```javascript
    const sum = (a, b) => a + b;
    ```
  - 함수는 단일 책임 원칙 준수
  - `forEach`, `map`, `filter`, `reduce`와 같은 배열 메서드를 적극 활용
    ```javascript
    // ✅ Good (functional programming)
    const numbers = [1, 2, 3];
    const doubled = numbers.map((num) => num * 2);

    // ❌ Bad (mutating original data)
    const numbers = [1, 2, 3];
    for (let i = 0; i < numbers.length; i++) {
      numbers[i] *= 2;
    }
    ```
- 모듈화
  - ES6 모듈 사용: import / export
  - import 순서: 외부 패키지 → 내부 모듈 → 스타일/자원 파일
    ```javascript
    import React from 'react';
    import { fetchData } from './api';
    import './styles.css';
    ```
- 주석
  - 함수, 클래스, 모듈은 JSDoc 스타일 주석
    ```javascript
    /**
    * 사용자 정보를 반환합니다.
    * @param {number} userId
    * @returns {Promise<User>}
      */
    async function getUser(userId) { /*...*/ }
    ```
- 예외 처리
  - try { ... } catch (error) { ... } 사용
  - 에러는 로깅하고 사용자에게는 일반화된 메시지 제공
    ```javascript
    try {
        const data = await fetchData();
    } catch (error) {
        console.error(error);
        alert('데이터 로드 중 오류가 발생했습니다.');
    }
    ```

### 3-3. JS 프레임워크
👀❓

### 3-4. 자동화 도구
| 항목       | ESLint                                                                                  | Prettier                        |
|------------|-----------------------------------------------------------------------------------------|---------------------------------|
| 역할       | 코드 품질 검사 (Linter)                                                                       | 코드 스타일 포맷터 (Formatter)          |
| 범위       | 문법, 버그, 코드 품질                                                                           | 코드 레이아웃/포맷                      |
| 주요 기능   | - 미사용 변수 감지<br>- `var` 금지, `let`/`const` 강제<br>- `==` 대신 `===` 사용 강제<br>- 함수 복잡도 검사<br>- 코드 스타일 일부 검사 (세미콜론, 따옴표 등) | - 들여쓰기 (2 spaces)<br>- 세미콜론 여부<br>- 따옴표(' vs ")<br>- 줄바꿈 방식<br>- 객체/배열 줄 정렬 방식 |
| 자동 수정  | 일부 규칙만 가능 (`--fix`)                                                                     | 전체 포맷 자동 정리 (`--write`)         |
| 확장성     | 플러그인으로 규칙 추가 가능                                                                         | 규칙 거의 없음 (단순 포맷)                |
- 코드 품질과 스타일 유지하기 위해 **ESLint + Prettier** 도구를 함께 사용
- 로컬 개발자
  - **ESLint** (코드 품질 검사기)
    - 잠재적 버그, 잘못된 문법, 코드 품질 문제 탐지
    - JSHint는 ES5 중심 도구로, 현재는 ES6+ 지원하는 ESLint 사용(업계 표준)
  - **Prettier** (코드 자동 포맷터)
    - 코드 스타일을 자동으로 일관되게 맞추기
  - 의존성 설치
    ```shell
    $ npm install --save-dev eslint prettier # 의존성 설치
      
    # eslint-config-prettier: Prettier와 충돌나는 ESLint 규칙 끔
    # eslint-plugin-prettier: ESLint 안에서 Prettier 실행
    $ npm install --save-dev eslint-config-prettier eslint-plugin-prettier
    ```
  - 설정 파일 생성
    - .eslintrc.json → ESLint 규칙 정의 (팀 공통 규칙 적용)
      ```json
      {
        "env": {
          "browser": true,
          "es2021": true
        },
        "extends": [
          "eslint:recommended",
          "plugin:prettier/recommended"
        ],
        "parserOptions": {
          "ecmaVersion": 2025,
          "sourceType": "module"
        },
        "rules": {
          "prettier/prettier": "error"
        }
      }
      ```
      ※ `"prettier/prettier": ["error"]`: ESLint와 Prettier 충돌 해소 가능
    - .prettierrc.json → Prettier 포맷 규칙 정의 (팀 공통 포맷 일관성 유지)
      ```
      {
        // 문자열은 싱글 쿼트 사용
        "singleQuote": true,

        // 세미콜론 강제
        "semi": true,

        // 줄 길이 제한, 자동 줄바꿈
        "printWidth": 120,

        // 들여쓰기 2 spaces
        "tabWidth": 2,

        // 탭 대신 spaces
        "useTabs": false,

        // 객체/배열의 마지막 요소 뒤에 콤마 추가
        "trailingComma": "es5",

        // 중괄호 안쪽 공백 허용
        "bracketSpacing": true,

        // HTML, Blade 등에서 속성이 여러 줄이면 닫는 꺾쇠 괄호는 새 줄에 배치
        "bracketSameLine": false,

        // 화살표 함수에서 인자 하나여도 괄호 사용
        "arrowParens": "always",
      }
      ```
  - IntelliJ IDEA 설정
    - ESLint
      - Settings → Languages & Frameworks → JavaScript → Code Quality Tools → ESLint
        - **Automatic ESLint configuration** 옵션 선택 (권장)
        - Run eslint --fix save 옵션 선택
    - Prettier
      - Settings → Languages & Frameworks → JavaScript → Prettier
        - **Automatic Prettier configuration** 옵션 선택 (권장)
        - Run on save 옵션 선택 (저장 시 자동 정리)
  - IntelliJ IDEA > Problem Description Sample
    ```
    ESLint: 'abc' is not defined. (no-undef)
    ESLint: 'xyz' is assigned a value but never used. (no-unused-vars)
    ```

---

## 4. CSS
### 4-1. 기본 원칙
- TailwindCSS **유틸리티 클래스 기반** 스타일링 우선
- 전역 스타일, 디자인 토큰은 `:root`에서 관리
- 필요 시 커스텀 CSS 작성 (컴포넌트별, 유틸 보완용)
- HTML에 불필요한 inline 스타일은 지양
- Stylelint를 사용하여 기본 CSS/변수 문법 검사

### 4-2. Coding Style
- 들여쓰기: **2 spaces**
  - 일반적으로 2 spaces 사용하며 CSS는 중첩이 많아 가독성을 위해 2 spaces 선호
  - .editorconfig (IDE에서 내부 설정보다 .editorconfig을 우선 적용)
    ```
    # .editorconfig
    .....
    [*.{js,ts,jsx,tsx,css}]
    indent_style = space
    indent_size = 2
    ```
  - IntelliJ IDEA → Settings → Editor → Code Style → Style Sheets → CSS
    - Tab size: 2
    - Indent: 2
    - Continuation indent: 2 (줄이 길 때 자동 들여쓰기)
- 한 줄 길이: **120자** 권장
- 중괄호 스타일: K&R 스타일처럼 속성과 같은 줄 시작
  ```css
  /* ✅ Good */
  .navbar {
    background: #333;
    color: #fff;
  }
    
  /* ❌ Bad */
  .navbar
  {
    background:#333;color:#fff;
  }
  ```
- 네이밍 규칙
  - BEM 방식 권장 (Block–Element–Modifier) 👀❓
    ```css
    /* Block */
    .card {}
        
    /* Element */
    .card__title {}
    .card__content {}
        
    /* Modifier */
    .card--highlighted {}
    ```
  - 일관된 소문자, 하이픈(-) 구분자 사용
    ```css
    /* ✅ Good */
    .main-header {}
    .btn-primary {}
        
    /* ❌ Bad */
    .MainHeader {}
    .btnPrimary {}
    ```
- 속성 선언 순서
  - 관련 속성끼리 묶어서 선언 (Stylelint 플러그인으로 자동화 가능)
    ```css
    .btn {
      display: inline-block;
      width: 100px;
      height: 40px;
    
      margin: 0;
      padding: 8px;
    
      font-size: 14px;
      font-weight: bold;
    
      color: #fff;
      background-color: #007bff;
    
      border: none;
      border-radius: 4px;
    }
    ```
- 단위와 값
  - 뒤에는 단위 쓰지 않음 → 0px ❌ → 0 ✅
  - rem, % → 반응형 우선
  - 색상은 #rrggbb 또는 rgba() 사용 (#fff 같은 축약형 허용)
- 주석
  - 블록 구분용 주석 권장
    ```css
    /* ========================================
    Buttons
    ======================================== */
    .btn {}
    .btn--primary {}
    ```

### 4-3. CSS 프레임워크
- TailwindCSS
  - 공식 사이트
    - [Tailwind CSS](https://tailwindcss.com/)
    - [Tailwind CSS - Docs](https://tailwindcss.com/docs)
    - [Install Tailwind CSS with Laravel](https://tailwindcss.com/docs/installation/framework-guides/laravel/vite)
  - 유틸리티 퍼스트(Utility-First) CSS 프레임워크
  - 미리 정의된 **작은 CSS 클래스(유틸리티 클래스)**를 조합해 UI를 만드는 방식
  - Bootstrap처럼 컴포넌트 제공이 아니라, 속성 단위 클래스 제공
  - 특징
    - 유틸리티 클래스 기반: bg-blue-500, px-4, py-2, rounded처럼 작은 단위로 스타일 적용
    - 커스터마이징 가능: tailwind.config.js에서 색상, 간격, 폰트 등 전역 디자인 토큰 정의 가능
    - 반응형 지원
    - Laravel과 연계 쉬움: Laravel Breeze, Jetstream 등 공식 패키지에서 기본 채택
    - SCSS 없이도 충분히 UI 구현 가능: 클래스 조합만으로 레이아웃과 스타일 구현 가능
  - 사용법
    - 의존성 설치 ⇒ Laravel 기본 포함
      ```shell
      $ npm install tailwindcss @tailwindcss/vite
      ```
    - Vite 환경파일에 `@tailwindcss/vite` 플러그인 추가 ⇒ Laravel 기본 포함
      ```ts
      import { defineConfig } from 'vite'
      import tailwindcss from '@tailwindcss/vite'
    
      export default defineConfig({
        plugins: [
          tailwindcss(),
          // …
        ],
      })
      ```
    - Import Tailwind CSS ⇒ Laravel 기본 포함
      - `./resources/css/app.css` 파일에 @import 추가
      - Tailwind CSS에 유틸리티 검색하도록 지시
      ```
      @import 'tailwindcss';
    
      @source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
      @source '../../storage/framework/views/*.php';
      @source '../**/*.blade.php';
      @source '../**/*.js';
      ```
    - 빌드 프로세스 시작
      ```shell
      $ npm run dev # 개발용 서버 실행 (HMR 지원)
      $ npm run build # 프로덕션 빌드 (최적화된 CSS 생성)
      ```
    - 프로젝트에서 Tailwind 사용 시작
      - 컴파일된 CSS를 <head>에 포함시킨 후 Tailwind 유틸리티 클래스 사용
      ```html
      <!doctype html>
      <html>
        <head>
          <meta charset="utf-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          @vite('resources/css/app.css')
        </head>
        <body>
          <h1 class="text-3xl font-bold underline">
            Hello world!
          </h1>
        </body>
      </html>
      ```

### 4-4. :root 전역 변수 👀❓
- 프로젝트 전반에 사용되는 값은 :root에서 정의
- 예시
  ```css
  /* resources/css/variables.css */
  :root {
    --border-radius-200: 0.25rem;
    --brand-primary: #1E40AF;
    --brand-secondary: #1E3A8A;
  }
  /* 사용 */
  .button {
    border-radius: var(--border-radius-200);
    background: var(--brand-primary);
  }
  ```

### 4-5. 커스텀 CSS
- Tailwind 유틸리티 클래스만으로 해결되지 않는 경우 사용.
- 예: 복잡한 애니메이션, 서드파티 라이브러리 스타일 오버라이드
  ```css
  /* resources/css/custom/button.css */
  .btn-primary {
    @apply px-4 py-2 text-white font-bold;
    background-color: var(--brand-primary);
    border-radius: var(--border-radius-200);
  }
  ```
  💡 @apply 지시어를 활용하면 Tailwind 유틸리티를 CSS 클래스에 재사용 가능

### 4-6. 자동화 도구
- 로컬 개발자
  - Prettier 👀❓
    - 의존성 설치
      ```shell
      $ npm install --save-dev prettier # 앞서 설치했으면 스킵
      
      # prettier-plugin-tailwindcss: Tailwind 클래스명을 자동으로 정렬해주는 도구
      $ npm install --save-dev prettier-plugin-tailwindcss
      ```
    - .prettierrc.json에 prettier-plugin-tailwindcss 플러그인 추가
       ```
       {
         "plugins": ["prettier-plugin-tailwindcss"]
       }
       ```
  - Stylelint
    - 의존성 설치
      ```shell
      $ npm install --save-dev stylelint
      
      # stylelint-config-standard: 공식 Stylelint 표준 규칙 세트
      # stylelint-config-tailwindcss: TailwindCSS 전용 Stylelint 설정
      $ npm install --save-dev stylelint-config-standard
      $ npm install --save-dev stylelint-config-tailwindcss
      ```
    - .stylelintrc.json
      ```json
      {
          "extends": [
              "stylelint-config-standard",
              "stylelint-config-tailwindcss"
          ],
          "ignoreFiles": [
              "node_modules/**",
              "public/**"
          ]
      }
      ```
      | Tailwind 유틸 클래스는 무시하고, 커스텀 CSS만 검증하는 것이 현실적
  - IntelliJ IDEA 설정
    - Stylelint
      - Settings → Languages & Frameworks → Style Sheets → Stylelint
        - Enable 체크 → 프로젝트 .stylelintrc.json 인식
        - Run stylelint --fix on save 옵션 선택
    - Prettier
      - Prettier 플러그인 설치
      - Settings → Languages & Frameworks → JavaScript → Prettier
        - Run for files에 `css` 추가
  - IntelliJ IDEA > Problem Description Sample
    ```
    Stylelint: Unexpected empty block (block-no-empty)
    ```
