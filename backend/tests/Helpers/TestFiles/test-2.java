import generatedcode.OperatorsBaseListener;
import generatedcode.OperatorsLexer;
import generatedcode.OperatorsParser;
import org.antlr.v4.runtime.*;
import org.antlr.v4.runtime.misc.Interval;
import org.antlr.v4.runtime.tree.ParseTree;
import org.antlr.v4.runtime.tree.ParseTreeWalker;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collection;

public class ListenerClass {

    private ArrayList<String> methods = new ArrayList<>();
    private CharStream charStream;
    private OperatorsParser parser;

    public ArrayList<String> getMethods() {
        return methods;
    }

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

    public ArrayList<String> parse(String code) {
        charStream = CharStreams.fromString(code);
        OperatorsLexer lexer = new OperatorsLexer(charStream);
        TokenStream tokens = new CommonTokenStream(lexer);
        OperatorsParser parser = new OperatorsParser(tokens);
        Listener listener = new Listener(charStream,lexer);
        parser.compilationUnit().enterRule(listener);
        return getMethods();
    }

    class Listener extends OperatorsBaseListener{
        private ArrayList<String> classes;
        private CharStream input;
        private OperatorsLexer lexer;

        public Listener(CharStream input, OperatorsLexer lexer) {
            classes = new ArrayList<>();
            this.input = input;
            this.lexer = lexer;
        }

        @Override
        public void enterCompilationUnit(OperatorsParser.CompilationUnitContext ctx){
            TypeClassListener typeClassListener= new TypeClassListener();
            ctx.typeDeclaration().forEach(declaration->declaration.enterRule(typeClassListener));
        }

        public ArrayList<String> getClasses() {
            return classes;
        }

    }

    class TypeClassListener extends OperatorsBaseListener{
        @Override
        public void enterTypeDeclaration(OperatorsParser.TypeDeclarationContext ctx){
            ClassDeclarationListener classDeclarationListener = new ClassDeclarationListener();
            ctx.classDeclaration().enterRule(classDeclarationListener);
        }
    }

    class ClassDeclarationListener extends OperatorsBaseListener{
        @Override
        public void enterClassDeclaration(OperatorsParser.ClassDeclarationContext ctx){
            ClassBodyListener classBodyListener = new ClassBodyListener();
            ctx.classBody().enterRule(classBodyListener);
        }
    }

    class ClassBodyListener implements OperatorsBaseListener{
        @Override
        public void enterClassBody(OperatorsParser.ClassBodyContext ctx){
            MemberDeclarationListener memberDeclarationListener = new MemberDeclarationListener();
            ClassDeclarationListener classDeclarationListener = new ClassDeclarationListener();
            TypeClassListener typeClassListener = new TypeClassListener();
            ctx.classBodyDeclaration().forEach(element-> {
                try{
                    if(!element.memberDeclaration().getText().startsWith("class")){
                        element.memberDeclaration().enterRule(memberDeclarationListener);
                    }else{
                        element.memberDeclaration().classDeclaration().enterRule(classDeclarationListener);
                    }
                }catch (NullPointerException e){
                    e.getMessage();
                }
            });
        }
    }

    /**
     * jvjfkjkfjs
     * jfaskjfkajsd
     */
    class ClassBodyDeclarationListener extends OperatorsBaseListener{
    }
    class MemberDeclarationListener extends OperatorsBaseListener{
        @Override
        public void enterMemberDeclaration(OperatorsParser.MemberDeclarationContext ctx){
            MethodDeclarationListener methodDeclarationListener = new MethodDeclarationListener(charStream);
            ClassDeclarationListener classDeclarationListener = new ClassDeclarationListener();
            if(!ctx.methodDeclaration().getText().startsWith("class")){
                ctx.methodDeclaration().enterRule(methodDeclarationListener);//fasdfasfds
            }else{
                ctx.methodDeclaration().enterRule(classDeclarationListener);
            }
            ;
        }
    }
    //fasdfkjashfkshakfsd
    class MethodDeclarationListener extends OperatorsBaseListener{

        private CharStream input;

        public MethodDeclarationListener(CharStream input){
            this.input = input;
        }

        @Override
        public void enterMethodDeclaration(OperatorsParser.MethodDeclarationContext ctx) throws NullPointerException{
            int a = ctx.start.getStartIndex();
            int b = ctx.stop.getStopIndex();
            Interval interval = new Interval(a,b);
            methods.add(input.getText(interval));
        }
    }
}