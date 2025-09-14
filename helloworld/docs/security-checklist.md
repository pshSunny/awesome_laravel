# 🛡️ 보안 가이드라인

이 문서는 Laravel 프로젝트 및 서버 운영에서 지켜야 할 **보안 원칙과 지침**을 정리한 문서입니다.  
개발자는 코드를 작성할 때, 운영 환경을 설정할 때, 그리고 배포를 준비할 때 이 지침을 참고하여 보안 사고를 예방해야 합니다.

---

우선순위 기준:
- ✅ **필수**: 반드시 적용해야 하는 항목 (보안 취약점 직결)
- 🔶 **권장**: 서비스 안정성/신뢰도 향상에 필요
- 🔹 **선택**: 상황/규모에 따라 적용 고려

---

## 1️⃣ Laravel 보안 설정
- [ ] ✅ `.env` 파일과 같은 민감 정보는 절대 Git에 포함 금지
- [ ] ✅ 프로덕션 환경에서는 `APP_ENV=production`과 `APP_DEBUG=false`를 설정 (디버그 모드 사용 금지)
- [ ] ✅ 애플리케이션 키(`APP_KEY`)는 안전하게 생성 및 관리
  - 개발/프로덕션 환경마다 서로 다른 키 사용
  - 프로덕션 환경에서는 APP_KEY를 반드시 .env에서 로드 (코드베이스 내 하드코딩 금지)
  - 키 노출 사고 발생 디비 재발급 프로세스 필요👀❓

---

## 2️⃣ 인증 & 권한 관리
- [ ] ✅ Laravel의 기본 인증 미들웨어 활용하여 접근 제어 적용
- [ ] ✅ Laravel **Sanctum/Passport** 사용 (API 인증 시)👀❓
- [ ] ✅ **비밀번호 해싱**: bcrypt/argon2 적용👀❓
- [ ] 🔶 **2단계 인증(2FA)**: OTP, SMS 등 추가 적용👀❓
- [ ] ✅ **권한(Role & Permission) 관리**: 사용자 / 관리자 / 판매자 구분👀❓

---

## 3️⃣ 입력값 검증 & 데이터 보호
- [ ] ✅ **Form Request Validation**으로 모든 입력값 검증
- [ ] ✅ **SQL Injection 방지**: 
  - Query Builder나 Eloquent ORM 사용
  - Raw Query 사용 시 파라미터 바인딩 필수
- [ ] ✅ **XSS 방지**:
  - Blade에서 `{{ }}` 사용 (unescaped `{!! !!}` 지양)
  - HTML 출력 시 위험한 태그 최소화
  - Content Security Policy(CSP) 적용하여 외부 스크립트/리소스 로딩 제한👀❓
- [ ] 🔶 **파일 업로드 보안**: MIME 타입 검증, 실행 가능한 스크립트 차단

---

## 4️⃣ 세션 & 쿠키
- [ ] ✅ **HTTPS 강제 적용** (`\App\Http\Middleware\TrustProxies` 설정)👀❓
- [ ] ✅ **세션 하이재킹 방지**: `.env`에서 `SESSION_SECURE_COOKIE=true`
- [ ] ✅ **세션 하이재킹 방지**: `.env`에서 `SESSION_HTTP_ONLY=true`
- [ ] ✅ **CSRF 보호**: Laravel **CSRF 토큰** 필수 적용 (폼/POST 요청)

---

## 5️⃣ 결제 & 민감정보
- [ ] ✅ **결제 정보 직접 저장 금지** (PG사 API만 사용)
- [ ] 🔶 **개인정보 암호화**: 전화번호, 주소 등은 `Crypt::encrypt` 고려
- [ ] ✅ **PCI-DSS 규격 준수** PG사 선택
- [ ] 🔶 결제/주문 시 **재시도·중복 결제 방지 로직** 적용

---

## 6️⃣ 서버 & 배포
- [ ] ✅ **환경파일(.env) 보호**: `.env` 외부 접근 차단, Git에 포함 금지
- [ ] ✅ **에러 메시지 노출 방지**: `APP_DEBUG=false` (운영 서버 필수)
- [ ] ✅ **서버 권한 최소화**: `storage`, `bootstrap/cache` 디렉토리만 쓰기 권한
- [ ] ✅ **보안 업데이트**: Laravel & Composer 패키지 최신 유지
- [ ] 🔶 HTTPS 인증서 최신 유지 (Let’s Encrypt 등)
- [ ] 🔶 서버에서 불필요한 포트와 서비스 차단
- [ ] 🔶 배포 과정에서 마이그레이션/시딩 권한 최소화 👀❓

---

## 7️⃣ 종속성 및 외부 서비스
- [ ] ✅ 프로젝트에서 사용하는 패키지는 정기적으로 취약점 검사 수행 (`composer audit`, `npm audit`) 👀❓
- [ ] ✅ 외부 API Key나 Secret은 `.env`에 안전하게 저장하고, 절대 코드에 직접 하드코딩 금지
- [ ] 🔶 불필요한 패키지는 제거하고, 라이브러리 업데이트 정책 수립 👀❓

---

## 8️⃣ 로깅 & 모니터링
- [ ] 🔶 Laravel 로그를 **중앙화** (ELK Stack, CloudWatch 등)👀❓
- [ ] 🔶 **보안 이벤트 알림**:👀❓
    - 관리자 로그인 실패
    - 비정상 다량 주문
    - 결제 오류 발생
- [ ] ✅ **로그 접근 제한** (로그 파일 외부 노출 금지)

---

## 9️⃣ 공격 방어
- [ ] ✅ **로그인 시도 제한**: `ThrottleRequests` 미들웨어 적용👀❓
- [ ] 🔶 **봇 방지**: reCAPTCHA/hCaptcha 적용 (회원가입, 결제 등 중요 단계)👀❓
- [ ] 🔶 **보안 HTTP 헤더 적용**:
    - `Content-Security-Policy`
    - `X-Frame-Options: DENY`
    - `X-Content-Type-Options: nosniff`
    - `Strict-Transport-Security`
- [ ] 🔶 **파일 업로드 보안**:
    - 확장자/파일 MIME 체크
    - 스토리지 분리 및 실행 방지: 업로드 파일은 public 경로 외부 저장
