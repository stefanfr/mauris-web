LANGUAGES=nld lim deu
PO_FILES=${foreach l, $(LANGUAGES), $l/LC_MESSAGES/default.po}
MO_FILES=$(PO_FILES:.po=.mo)
PO_TEMPLATE=default.pot

all: mo pot

full:
	@$(MAKE) --no-print-directory pot
	@$(MAKE) --no-print-directory msgmerge
	@$(MAKE) --no-print-directory mo

mo: $(MO_FILES)
pot: $(PO_TEMPLATE)

clean:
	-$(RM) $(MO_FILES)

%.mo: %.po
	msgfmt -o $@ $<

$(PO_TEMPLATE):
	../Console/cake i18n extract --app . --paths .. --extract-core no --output . --merge no --overwrite

msgmerge:
	$(foreach p, $(PO_FILES), echo Updating $p ; msgmerge -U $p $(PO_TEMPLATE) ; )
