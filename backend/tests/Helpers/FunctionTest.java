public ArrayList<String> parse(File code) throws IOException {
    charStream = CharStreams.fromFileName(code.getName());
    OperatorsLexer lexer = new OperatorsLexer(charStream);
    Counter counter = new Counter();
    TokenStream tokens = new CommonTokenStream(lexer);
    parser = new OperatorsParser(tokens);
    Listener listener = new Listener(charStream,lexer);
    parser.compilationUnit().enterRule(listener);
    return getMethods();
}