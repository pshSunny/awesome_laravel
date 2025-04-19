# awesome_laravel

MAC 개발환경

# Homebrew 최신 상태 갱신
`$ brew update`

# PHP 설치
`$ brew install php@8.1`

# Composer 설치
```bash
brew install composer
~.composer/vendor/bin 디렉토리가 시스템 "PATH"에 있는지 확인
```

# MySQL 설치
※ https://programmerjoon.tistory.com/23
```bash
brew install mysql@5.7 => root 계정 비밀번호 없이 mysql만 설치됨.
brew services start mysql => 시스템 시작할 때 자동 실행 명령어 (X)
mysql.server start => MySQL 실행
```

# Laravel 설치
```bash
composer global require "laravel/installer"
echo $SHELL => 현재 사용중인 쉘 확인
vi ~/.zshrc
export PATH="$HOME/.composer/vendor/bin:$PATH"
source ~/.zshrc => 설정파일 새로고침
echo $PATH => PATH 목록확인
```

# Laravel Project 준비
```bash
cd awesome_laravel
composer create-project laravel/laravel helloworld
```

# git push
```bash
cd awesome_laravel
git init
git config --local --list
git config --local user.name "pshSunny"
git config --local user.email "psh@100yearshop.co.kr"
git add .
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:pshSunny/awesome_laravel.git
git push -u origin main
```
※ https://usingu.co.kr/frontend/git/한-컴퓨터에서-github-계정-여러개-사용하기/

# Laravel Valet(발렛) 설치
https://laravel.kr/docs/9.x/valet
```bash
composer global require laravel/valet => 글로벌 Composer 패키지로 설치할 수 있음
valet install => Valet 및 DnsMasq, nginx 설치. 시스템 시작될 때 실행되도록 설정됨.
ping foobar.test => 127.0.0.1로 응답하면 Valet 정상 설치된 것임.
```

# Laravel Valet으로 사이트 동작
```bash
cd awesome_laravel/helloworld
valet link => 디렉터리 이름 사용하여 http://helloworld.test 도메인으로 액세스
valet link api.application => 서브도메인 액세스하는 경우
valet links => 연결된 모든 디렉토리 목록 표시
valet unlink => 사이트 심볼릭 링크 제거

또는,
cd ~/Sites
valet park => 디렉토리 파킹. 하위 디렉토리를 http://디렉토리명.test로 엑세스 가능
```

# ETC 설치
## xDebug 설치 (커버리지)
```bash
pecl install xdebug
```

### 커버리지
```bash
XDEBUG_MODE=coverage php artisan test --coverage
```

### perl 설치 안된 경우
```bash
brew install perl
```

### "/usr/bin/perl5.30: bad interpreter: No such file or directory" 에러 발생한 경우
```bash
brew update
brew upgrade autoconf
```

# Laravel 11 Upgrade (from. 10)
Laravel 공식 업그레이드 가이드 : https://laravel.com/docs/11.x/upgrade
요구사항 : PHP 8.2 이상

## PHP Version Up (from. php@8.1)
```bash
brew update
brew install php@8.2
brew unlink php@8.1
brew link --overwrite php@8.2
echo 'export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"' >> /Users/sunny/.zshrc
echo 'export PATH="/opt/homebrew/opt/php@8.2/sbin:$PATH"' >> /Users/sunny/.zshrc
# 새창에서
php -v
valet use php@8.2
valet status
valet restart
brew services stop php@8.1
```

## 버전 갱신된 composer.json 파일을 git pull로 받은 경우
`composer update`

## Compoer로 Laravel 프레임워크 업그레이드하는 경우
`composer require laravel/framework:^11.0 --update-with-dependencies`
호환 이슈로 실패되면 공식 업그레이드 가이드 참고하여 composer.json 에서 버전 수정 후 `composer update` 실행

## Larable 버전 확인
`php artisan --version`
Laravel Framework 11.0.6
`composer show laravel/framework`
```yaml
name     : laravel/framework
descrip. : The Laravel Framework.
keywords : framework, laravel
versions : * v11.0.6
released : 2024-03-14, 9 months ago
...
```


# VSCode
## 확장 플러그인
- Korean Language Pack (Microsoft) : VS Code용 한국어 팩
- Laravel Artisan (Ryan Naddy) : artisan 명령어를 바로바로 제공해주는 익스텐션 => `>route list`
- Laravel Blade Snippets (Winnie Lin) : 라라벨 뷰를 담당하는 블레이드 템플릿에서 코드 자동완성 도와주는 익스텐션
  ```
  html:5
  div.abc>div.xyz
  h1
  bye => @yield
  bse => @section
  ```
- Larabel Blade Spacer (Austen Cameron) : 블레이드 템플릿에서 { 기호 뒤에 자동으로 공백 추가, 블레이드 코드 (`{{  }}` `{!!  !!}`) 인식하는 익스텐션 
- Laravel Snippets (Winnie Lin) : 라라벨의 코드 자동완성 익스텐션
- Laravel goto view (ctf0) : 라라벨 컨트롤러에서 ctrl 키를 누른 채로 클릭하면 곧바로 해당 뷰로 이동
    - 프로젝트 디렉토리 내 라라벨 디렉토리라면 확장 설정에서 Default Path 설정 필요
- laravel extra intellisense (amir) : 라라벨 route 코드 자동완성 익스텐션
    - 되는지 모르겠음.
- MySQL (Weijan Chen) : Database-client => https://yooloo.tistory.com/m/264
- material icon theme (Philipp Kief) : 여러 파일과 디렉토리의 아이콘을 알기 쉽게 바꿔주는 익스텐션
- env (Jakka Prihatna) : .env 파일 코드를 보기쉽게 색깔 넣어주는 익스텐션
- PHP IntelliSense (Damjan Cvetko) : PHP 고급 자동완성 및 리팩터링 지원
- PHP Intelephense (Ben Mewburn) :  문서, 작업 영역, 기본 제공 생성자, 메서드 및 함수에 대한 자세한 서명 도움, 오류 허용 구문 분석기를 통해 열린 파일에 대한 여러 구문 분석 오류 진단
- Todo Tree (Gruntfuggly) : Todo Tree 익스텐션
  - Tags 설정에 '@TODO' 추가
- php cs fixer (junstyle) : php formatter
  - https://github.com/junstyle/vscode-php-cs-fixer
  - 확장 패키지 Configuration 설정 참고하여 .vscode/settings.json 수정
    - php-cs-fixer.executablePath : `"${extensionPath}/php-cs-fixer.phar"`
    - php > editor.defaultFormatter : `"editor.defaultFormatter": "junstyle.php-cs-fixer"`
  - .php-cs-fixer.php 설정 파일
    - PhpCsFixer를 로컬 의존성으로 설치 : `composer require --dev friendsofphp/php-cs-fixer`
    - .php-cs-fixer.php 파일을 프로젝트 루트에 배치 : `helloworld/.php-cs-fixer.php`
    - VS Code settings.json 설정 : `"php-cs-fixer.config": "helloworld/.php-cs-fixer.php",`
  - 단축키 설정
    - php-cs-fixer: fix : Ctrl+Shift+F => 전체 프로젝트 또는 설정된 Finder 범위 전체 파일 포맷
    - php-cs-fixer: fix this file : 미설정 => 현재 열려 있는 파일만 포맷
- Format HTML in PHP (rifi2k)
  - 단축키 : Ctrl+Option+F
- Supermaven
  - free version으로 충분(이메일 입력)
  - Auto Completion(자동완성), Cursor Prediction(코드 예측)을 제공하는데, 자동완성 위주로 사용해도 충분.


## 단축키
설정 열기: Cmd+,
파일로 이동: Cmd+p
줄 이동: Ctrl+g
클래스 / 메소드 이동 : Cmd+click, 커서+F12 (전제:PHP Intelephense 플러그인)
터미널 보기: Ctrl+`
새터미널 보기: Ctrl+Shift+`
터미널 포커스 이동: Shift+Cmd+[/]
php-cs-fixer: fix: Ctrl+Shift+F
Format HTML in PHP: Ctrl+Option+F


# 프로젝트 갱신 & 재시작
composer update
php artisan migrate
npm run dev => 에셋 번들러 개발 환경용 빌드
mailhog => macOS 개발환경용 로컬 메일 테스트 도구


# 메일 테스트 환경: mailhog(macOS 개발환경용 로컬 메일 테스트 도구)
## 설치 & 실행
설치: brew install mailhog
실행: mailhog
백그라운드 실행: brew services restart mailhog
URL: http://0.0.0.0:8025

## .env > mail
```
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
```

## 메일 테스트 코드
```bash
php artisan tinker

use Illuminate\Support\Facades\Mail;

Mail::raw('Test Mail', function ($message) {
    $message->to('recipient@example.com')
            ->subject('Test Subject');
});
```


# 참고 사이트
라라벨 코리아: https://laravel.kr
업그레이드 가이드(10.x > 11.0): https://laravel.com/docs/11.x/upgrade
Socialite Providers(소셜로그인) : https://socialiteproviders.com
GitHub Authorizing OAuth Apps : https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/authorizing-oauth-apps
네이버 로그인 API 명세 : https://developers.naver.com/docs/login/api/api.md
카카오 로그인 : https://developers.kakao.com/docs/latest/ko/kakaologin/common
Mockery : http://docs.mockery.io

# 주요 파일
app/Providers/RouteServiceProvider.php : 라우트 서비스 프로바이더 > 라우트 파일 지정
app/Http/Middleware : 미들웨어 디렉터리
app/Http/Kernel.php : 미들웨어 명시 (전역 미들웨어, 미들웨어 그룹, 개별 라우트 미들웨어)
app/Http/Middleware/RedirectIfAuthenticated.php : guest 미들웨어 > 유저 로그인하지 않은 경우 컨트롤러 도달
app/Http/Middleware/Authenticate.php : auth 미들웨어 > 유저 로그인 되어 있는 경우 컨트롤러 도달
app/Http/Middleware/VerifyCsrfToken.php : CSRf Except 정의 미들웨어
app/Http/Middleware/TrimStrings.php : 여백 처리 미들웨어
Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class : 빈 값 null 변환하는 미들웨어
Illuminate\Validation\Rules\Password : 비밀번호 유효성 검사 규칙 클래스
app/Providers/PasswordServiceProvider.php : 비밀번호 유효성 검사 서비스 프로바이더


# .env > session 설정
SESSION_DRIVER=database
SESSION_CONNECTION=mysql

