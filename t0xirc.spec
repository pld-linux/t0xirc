Summary:	A PHP to Eggdrop gateway class
Name:		t0xirc
Version:	1.0.4
Release:	0.2
License:	GPL v2
Group:		Libraries
Source0:	http://t0xirc.si.kz/downloads/%{name}_%{version}.tgz
# Source0-md5:	f529648d6e00d1db7fb8c06580b05198
Source1:	%{name}.php
URL:		http://t0xirc.si.kz/
Requires:	php-common
BuildArch:	noarch
BuildRoot:	%{tmpdir}/%{name}-%{version}-root-%(id -u -n)

%define		_appdir	%{_datadir}/php

%description
t0xirc is a PHP class that enable your applications to interact with
the popular IRC bot Eggdrop.

%prep
%setup -q -n %{name}_%{version}

%install
rm -rf $RPM_BUILD_ROOT
install -d $RPM_BUILD_ROOT{%{_bindir},%{_appdir},%{_examplesdir}/%{name}-%{version}}
cp -a t0xirc.php $RPM_BUILD_ROOT%{_appdir}
cp -a example.php $RPM_BUILD_ROOT%{_examplesdir}/%{name}-%{version}
install %{SOURCE1} $RPM_BUILD_ROOT%{_bindir}/%{name}

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(644,root,root,755)
%doc ChangeLog README
%attr(755,root,root) %{_bindir}/t0xirc
%{_appdir}/*
%{_examplesdir}/*
