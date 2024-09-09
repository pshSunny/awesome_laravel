# awesome_laravel

MAC 개발환경

# Homebrew 최신 상태 갱신
`$ brew update`

# PHP 설치
`$ brew install php@8.1`

# Composer 설치
```
$ brew install composer
~.composer/vendor/bin 디렉토리가 시스템 "PATH"에 있는지 확인
```

# MySQL 설치
※ https://programmerjoon.tistory.com/23
```
$ brew install mysql@5.7 => root 계정 비밀번호 없이 mysql만 설치됨.
$ brew services start mysql => 시스템 시작할 때 자동 실행 명령어 (X)
$ mysql.server start => MySQL 실행
```

# Laravel 설치
```
$ composer global require "laravel/installer"
$ echo $SHELL => 현재 사용중인 쉘 확인
$ vi ~/.zshrc
export PATH="$HOME/.composer/vendor/bin:$PATH"
$ source ~/.zshrc => 설정파일 새로고침
$ echo $PATH => PATH 목록확인
```

# Laravel Project 준비
```
$ cd awesome_laravel
$ composer create-project laravel/laravel helloworld
```

# git push
```
$ cd awesome_laravel
$ git init
$ git config --local --list
$ git config --local user.name "pshSunny"
$ git config --local user.email "psh@100yearshop.co.kr"
$ git add .
$ git commit -m "first commit"
$ git branch -M main
$ git remote add origin git@github.com:pshSunny/awesome_laravel.git
$ git push -u origin main
```
※ https://usingu.co.kr/frontend/git/한-컴퓨터에서-github-계정-여러개-사용하기/

# Laravel Valet(발렛) 설치
https://laravel.kr/docs/9.x/valet
```
$ composer global require laravel/valet => 글로벌 Composer 패키지로 설치할 수 있음
$ valet install => Valet 및 DnsMasq, nginx 설치. 시스템 시작될 때 실행되도록 설정됨.
$ ping foobar.test => 127.0.0.1로 응답하면 Valet 정상 설치된 것임.
```

# Laravel Valet으로 사이트 동작
```
$ cd awesome_laravel/helloworld
$ valet link => 디렉터리 이름 사용하여 http://helloworld.test 도메인으로 액세스
$ valet link api.application => 서브도메인 액세스하는 경우
$ valet links => 연결된 모든 디렉토리 목록 표시
$ valet unlink => 사이트 심볼릭 링크 제거

또는,
$ cd ~/Sites
$ valet park => 디렉토리 파킹. 하위 디렉토리를 http://디렉토리명.test로 엑세스 가능
```

# VSCode
## 확장 플러그인
- Korean Language Pack : VS Code용 한국어 팩
- Laravel Blade Snippets : 라라벨의 뷰를 담당하는 블레이드의 템플릿 제공
- Laravel Snippets : 라라벨의 코드 템플릿 제공
- Laravel goto view : 라라벨 컨트롤러에서 ctrl 키를 누른 채로 클릭하면 곧바로 해당 뷰로 이동
- Larabel Blade Spacer : 블레이드 템플릿에서 { 기호 뒤에 자동으로 공백 추가
- MySQL (Weijan Chen) : Database-client => https://yooloo.tistory.com/m/264

## 단축키
command+p : 파일로 이동
control+g : 줄 이동
